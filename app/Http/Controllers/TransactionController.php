<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Product;
use App\Models\Category;
use Spatie\Dropbox\Client;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Services\FonnteService;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\Log;
use App\Services\DropboxTokenProvider;
use Illuminate\Support\Facades\Session;

class TransactionController extends Controller
{
    protected $client;
    protected $fonnteService;

    public function __construct(FonnteService $fonnteService)
    {
        $this->client = new Client($this->getValidAccessToken());
        $this->fonnteService = $fonnteService;
    }

    /**
     * Mendapatkan token akses yang valid.
     */
    private function getValidAccessToken()
    {
        // Menggunakan DropboxTokenProvider untuk mengelola token
        $tokenProvider = new DropboxTokenProvider();
        return $tokenProvider->getToken();
    }


    // Menampilkan halaman transaksi dengan daftar produk dan keranjang
    public function index(Request $request)
    {
        $search = $request->get('search');
        $selectedCategoryId = $request->get('category');

        // Ambil kategori
        $categories = Category::orderBy('name')->pluck('name', 'id');

        // Ambil produk sesuai filter
        $products = Product::query()
            ->when($selectedCategoryId, fn($query) => $query->where('category_id', $selectedCategoryId))
            ->when($search, fn($query) => $query->where('nama', 'like', '%' . $search . '%')
                ->orWhereHas('category', fn($query) => $query->where('name', 'like', '%' . $search . '%')))
            ->with('category')
            ->get();

        // Ambil data keranjang dari session
        $cart = session()->get('cart', []);
        $subtotal = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart));

        return view('pages.transactions.index', compact('products', 'categories', 'selectedCategoryId', 'cart', 'subtotal'));
    }

    // Menambahkan produk ke keranjang
    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);

        if ($product->stok < $request->quantity) {
            return back()->with('error', 'Stok tidak mencukupi.');
        }

        // Menyimpan produk di keranjang session
        $cart = Session::get('cart', []);
        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $request->quantity;
        } else {
            $cart[$product->id] = [
                'id' => $product->id,
                'name' => $product->nama,
                'price' => $product->harga,
                'quantity' => $request->quantity,
            ];
        }

        // Update session keranjang
        Session::put('cart', $cart);

        return back()->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }

    // Menghapus produk dari keranjang
    public function removeFromCart($productId)
    {
        $cart = Session::get('cart', []);
        unset($cart[$productId]);
        Session::put('cart', $cart);

        return back()->with('success', 'Produk berhasil dihapus dari keranjang.');
    }

    // Menyelesaikan transaksi
    // Menyelesaikan transaksi
    public function completeCart()
    {
    $cart = session()->get('cart', []);
    if (empty($cart)) {
        return redirect()->back()->with('error', 'Keranjang kosong.');
    }

    $transaction = Transaction::create(['status' => 'completed']);

    foreach ($cart as $productId => $item) {
        $product = Product::findOrFail($productId);

        if ($product->stok < $item['quantity']) {
            return redirect()->back()->with('error', "Stok produk {$product->name} tidak mencukupi.");
        }

        TransactionDetail::create([
            'transaction_id' => $transaction->id,
            'product_id' => $product->id,
            'quantity' => $item['quantity'],
            'subtotal' => $item['quantity'] * $product->harga,
        ]);

        $product->decrement('stok', $item['quantity']);
    }

    // Buat PDF dari struk transaksi
    $pdf = $this->generateReceiptPDF($transaction);

    // Simpan sementara ke storage lokal
    $filePath = storage_path("app/public/struk-transaksi-{$transaction->id}.pdf");
    $pdf->save($filePath);

    // Unggah ke Dropbox
    try {
        $this->client->upload("/struk-transaksi-{$transaction->id}.pdf", file_get_contents($filePath));
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Gagal mengunggah struk ke Dropbox: ' . $e->getMessage());
    }

    // Hapus file lokal setelah diunggah
    unlink($filePath);

    // Kosongkan keranjang
    session()->forget('cart');

    return redirect()->route('pages.transactions.success', ['transactionId' => $transaction->id]);
    }
    public function success($transactionId)
    {
        $transaction = Transaction::with('details.product.category')->findOrFail($transactionId);

        return view('pages.transactions.success', compact('transaction'));
    }

    public function searchProduct(Request $request)
    {
    $query = $request->get('query', '');
    $products = Product::query()
        ->where('nama', 'like', '%' . $query . '%')
        ->select('id', 'nama', 'harga')
        ->take(10) // Batasi hasil pencarian maksimal 10
        ->get();

    return response()->json($products);
    }
    public function history(Request $request)
    {
        $search = $request->get('search');

        $transactions = TransactionDetail::with('product.category', 'transaction')
            ->when($search, fn($query) => $query->whereHas('product', fn($query) => $query->where('nama', 'like', '%' . $search . '%')
                ->orWhereHas('category', fn($query) => $query->where('name', 'like', '%' . $search . '%'))))
            ->whereHas('transaction', fn($query) => $query->whereIn('status', ['completed', 'cancelled']))
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pages.transactions.history', compact('transactions'));
    }

    // Membuat PDF dari struk
    private function generateReceiptPDF($transaction)
    {
        return PDF::loadView('pages.transactions.receipt', compact('transaction'));
    }

    public function printReceipt($transactionId)
    {
        $transaction = Transaction::with('details.product.category')->findOrFail($transactionId);
        $pdf = $this->generateReceiptPDF($transaction);
        return $pdf->stream('struk-transaksi-' . $transaction->id . '.pdf');
    }

    public function downloadReceipt($transactionId)
    {
        $transaction = Transaction::with('details.product.category')->findOrFail($transactionId);
        $pdf = $this->generateReceiptPDF($transaction);
        return $pdf->download('struk-transaksi-' . $transaction->id . '.pdf');
    }
    public function sendToWA(Request $request, $transactionId)
{
    $request->validate([
        'whatsapp_number' => 'required|regex:/^[0-9]{10,15}$/',
    ]);

    $transaction = Transaction::with('details.product.category')->findOrFail($transactionId);

    // Generate PDF struk transaksi
    $pdf = $this->generateReceiptPDF($transaction);

    // Simpan sementara file PDF
    $localFilePath = storage_path("app/public/struk-transaksi-{$transaction->id}.pdf");
    $pdf->save($localFilePath);

    try {
        // Unggah file ke Dropbox dan ambil link sementara
        $dropboxPath = "/struk/struk-transaksi-{$transaction->id}.pdf";
        $this->client->upload($dropboxPath, file_get_contents($localFilePath));
        $temporaryLink = $this->client->getTemporaryLink($dropboxPath);
        Log::info("Link Dropbox: {$temporaryLink}");

        // Nomor WhatsApp tujuan
        $whatsappNumber = $request->whatsapp_number;

        // Kirim ke WhatsApp menggunakan FonnteService
        $message = "Halo, berikut adalah link struk transaksi Anda dengan ID: {$transaction->id}. Terima kasih telah berbelanja! \n\nLink Struk: {$temporaryLink}";
        $this->fonnteService->sendMessage($whatsappNumber, $message);

        // Hapus file lokal setelah berhasil diunggah
        unlink($localFilePath);

        return redirect()->route('pages.transactions.success', ['transactionId' => $transaction->id])
            ->with('success', 'Struk berhasil dikirim ke WhatsApp!');
    } catch (\Exception $e) {
        unlink($localFilePath); // Pastikan file lokal dihapus jika terjadi kesalahan
        return back()->with('error', 'Gagal mengirim struk ke WhatsApp: ' . $e->getMessage());
    }
}
}
