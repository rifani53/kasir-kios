<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Http\Request;
use PDF; // Pastikan Anda telah menginstal barryvdh/laravel-dompdf
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    
    // Menampilkan halaman transaksi dengan produk dan filter kategori
    public function index(Request $request)
    {
        // Mengambil kategori unik dari tabel kategori
        $categories = Category::orderBy('name')->pluck('name', 'id');

        $selectedCategoryId = $request->get('category');

        // Mengambil produk berdasarkan kategori yang dipilih atau semua produk
        if ($selectedCategoryId) {
            $products = Product::where('category_id', $selectedCategoryId)->with('category')->get();
            $selectedCategoryName = Category::find($selectedCategoryId)->name;
        } else {
            $products = Product::with('category')->get();
            $selectedCategoryName = null;
        }

        // Mengambil transaksi yang statusnya 'pending' beserta produk terkait
        $transactions = Transaction::with('product.category')->where('status', 'pending')->get();

        // Hitung total harga dari semua transaksi yang 'pending'
        $totalAmount = $transactions->sum('total_price');

        return view('pages.transactions.index', compact('products', 'categories', 'selectedCategoryId', 'selectedCategoryName', 'transactions', 'totalAmount'));
    }

    // Menambah transaksi (banyak produk sekaligus)
    public function store(Request $request)
    {
        $request->validate([
            'product_ids' => 'required|array|min:1',
            'product_ids.*' => 'exists:products,id',
            'quantities' => 'required|array',
            'quantities.*' => 'integer|min:1',
        ], [
            'product_ids.required' => 'Pilih minimal satu produk untuk transaksi.',
            'product_ids.*.exists' => 'Produk yang dipilih tidak valid.',
            'quantities.required' => 'Jumlah produk diperlukan.',
            'quantities.*.integer' => 'Jumlah produk harus berupa angka.',
            'quantities.*.min' => 'Jumlah produk minimal adalah 1.',
        ]);

        $productIds = $request->input('product_ids');
        $quantities = $request->input('quantities');

        // Mulai transaksi database untuk keamanan
        DB::transaction(function () use ($productIds, $quantities) {
            foreach ($productIds as $productId) {
                $quantity = $quantities[$productId] ?? 1;
                $product = Product::findOrFail($productId);
                $totalPrice = $product->harga * $quantity;

                Transaction::create([
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'total_price' => $totalPrice,
                    'status' => 'pending',
                ]);
            }
        });

        return redirect()->back()->with('success', 'Transaksi berhasil ditambahkan.');
    }

    // Membatalkan transaksi
    public function cancel($id)
    {
        $transaction = Transaction::findOrFail($id);

        if ($transaction->status === 'pending') {
            $transaction->update(['status' => 'cancelled']);
            return redirect()->back()->with('success', 'Transaksi dibatalkan.');
        }

        return redirect()->back()->with('error', 'Transaksi tidak dapat dibatalkan.');
    }

    // Menandai transaksi sebagai selesai dan mencetak struk
    public function complete($id)
    {
        $transaction = Transaction::findOrFail($id);

        if ($transaction->status === 'pending') {
            $transaction->update(['status' => 'completed']);
            return redirect()->route('transactions.print', $transaction->id);
        }

        return redirect()->back()->with('error', 'Transaksi tidak dapat diselesaikan.');
    }

    // Mencetak struk
    public function printReceipt($id)
    {
        $transaction = Transaction::with('product.category')->findOrFail($id);

        $pdf = PDF::loadView('pages.transactions.receipt', compact('transaction'));

        return $pdf->download('struk_transaksi_'.$transaction->id.'.pdf');
    }
}
