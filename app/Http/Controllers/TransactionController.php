<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use PDF; // Pastikan Anda telah menginstal barryvdh/laravel-dompdf

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
        ->when($selectedCategoryId, function ($query) use ($selectedCategoryId) {
            $query->where('category_id', $selectedCategoryId);
        })
        ->when($search, function ($query) use ($search) {
            $query->where('nama', 'like', '%' . $search . '%')
                  ->orWhereHas('category', function ($query) use ($search) {
                      $query->where('name', 'like', '%' . $search . '%');
                  });
        })
        ->with('category')
        ->get();

    // Ambil transaksi yang pending dari TransactionDetail
    $transactions = TransactionDetail::with('product.category')
        ->when($search, function ($query) use ($search) {
            $query->whereHas('product', function ($query) use ($search) {
                $query->where('nama', 'like', '%' . $search . '%')
                      ->orWhereHas('category', function ($query) use ($search) {
                          $query->where('name', 'like', '%' . $search . '%');
                      });
            });
        })
        ->whereHas('transaction', function ($query) {
            $query->where('status', 'pending');
        })
        ->get();

    // Hitung total harga dari TransactionDetail
    $totalAmount = $transactions->sum('total_price');

    return view('pages.transactions.index', compact(
        'products',
        'categories',
        'selectedCategoryId',
        'transactions',
        'totalAmount'
    ));
}

public function history(Request $request)
{
    // Ambil pencarian dan filter dari request
    $search = $request->get('search');

    // Ambil transaksi yang selesai atau dibatalkan berdasarkan status
    $transactions = TransactionDetail::with('product.category', 'transaction')
        ->when($search, function ($query) use ($search) {
            $query->whereHas('product', function ($query) use ($search) {
                $query->where('nama', 'like', '%' . $search . '%')
                      ->orWhereHas('category', function ($query) use ($search) {
                          $query->where('name', 'like', '%' . $search . '%');
                      });
            });
        })
        ->whereHas('transaction', function ($query) {
            $query->whereIn('status', ['completed', 'cancelled']);
        })
        ->orderBy('created_at', 'desc')
        ->get();
    return view('pages.transactions.history', compact('transactions'));
}
    // Menambah transaksi (banyak produk sekaligus)
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

    // Cek apakah sudah ada transaksi dengan status pending
    $transaction = Transaction::where('status', 'pending')->first();

    // Jika tidak ada transaksi pending, buat transaksi baru
    if (!$transaction) {
        $transaction = Transaction::create([
            'status' => 'pending', // status awal adalah pending
        ]);
    }
    // Perbarui stok produk

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

    // Ambil transaksi yang statusnya pending
    $transaction = Transaction::where('status', 'pending')->first();

    if (!$transaction) {
        return redirect()->back()->with('error', 'Tidak ada transaksi pending.');
    }

    // Ubah status transaksi menjadi completed
    $transaction->update(['status' => 'completed']);

    // Proses setiap item di keranjang dan simpan detail transaksi
    foreach ($cart as $productId => $item) {
        $product = Product::findOrFail($productId);

        // Validasi stok
        if ($product->stok < $item['quantity']) {
            return redirect()->back()->with('error', "Stok produk {$product->name} tidak mencukupi.");
        }

        // Simpan detail transaksi
        TransactionDetail::create([
            'transaction_id' => $transaction->id,
            'product_id' => $product->id,
            'quantity' => $item['quantity'],
            'total_price' => $item['quantity'] * $product->harga,
        ]);

        // Update stok produk
        $product->decrement('stok', $item['quantity']);
        $product->increment('total_sold', $item['quantity']);
        $product->increment('sales_count', $item['quantity']);
    }

    // Bersihkan keranjang
    session()->forget('cart');

    return redirect()->route('pages.transactions.success', ['transactionId' => $transaction->id]);
}
    // Membatalkan keranjang
    public function cancelCart()
{
    session()->forget('cart');
    return back()->with('success', 'Keranjang berhasil dibatalkan.');
}

    public function success($transactionId)
{
    $transaction = Transaction::with('details.product.category')->findOrFail($transactionId);

    // Menampilkan halaman sukses dengan detail transaksi
    return view('pages.transactions.success', compact('transaction'));
}
    // Mencetak struk
    public function printReceipt()
{
    $successTransaction = session()->get('success_transaction');

    if (!$successTransaction) {
        return redirect()->route('pages.transactions.index')->with('error', 'Tidak ada transaksi untuk dicetak.');
    }

    $pdf = PDF::loadView('pages.transactions.receipt', [
        'transactions' => $successTransaction['transactions'],
        'totalPrice' => $successTransaction['totalPrice'],
        'transactionDate' => $successTransaction['transactionDate'],
    ]);

    return $pdf->stream('struk_transaksi_' . now()->format('Ymd_His') . '.pdf');
}
public function downloadReceipt($transactionId)
{
    $transaction = Transaction::with('details.product.category')->findOrFail($transactionId);

    // Membuat PDF dari view
    $pdf = PDF::loadView('pages.transactions.receipt', compact('transaction'));

    // Download PDF
    return $pdf->download('struk-transaksi-' . $transaction->id . '.pdf');
}
}
