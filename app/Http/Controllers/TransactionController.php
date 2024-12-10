<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use PDF;

class TransactionController extends Controller
{
    // Menampilkan halaman transaksi dengan produk dan filter kategori
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

        // Ambil transaksi yang pending
        $transactions = TransactionDetail::with('product.category')
            ->when($search, fn($query) => $query->whereHas('product', fn($query) => $query->where('nama', 'like', '%' . $search . '%')
                ->orWhereHas('category', fn($query) => $query->where('name', 'like', '%' . $search . '%'))))
            ->whereHas('transaction', fn($query) => $query->where('status', 'pending'))
            ->get();

        $totalAmount = $transactions->sum('total_price');

        return view('pages.transactions.index', compact('products', 'categories', 'selectedCategoryId', 'transactions', 'totalAmount'));
    }

    // Menampilkan riwayat transaksi
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

    // Menampilkan isi keranjang
    public function showCart()
    {
        $cart = session()->get('cart', []);
        $totalPrice = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart));

        return view('pages.transactions.cart', compact('cart', 'totalPrice'));
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

        session()->forget('cart');

        return redirect()->route('pages.transactions.success', ['transactionId' => $transaction->id]);
    }

    // Membatalkan keranjang
    public function cancelCart()
    {
        session()->forget('cart');
        return back()->with('success', 'Keranjang berhasil dibatalkan.');
    }

    // Menampilkan halaman sukses transaksi
    public function success($transactionId)
    {
        $transaction = Transaction::with('details.product.category')->findOrFail($transactionId);

        return view('pages.transactions.success', compact('transaction'));
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
}
