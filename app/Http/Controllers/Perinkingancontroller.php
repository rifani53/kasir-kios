<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\TransactionDetail;

class Perinkingancontroller extends Controller
{
    // Mendapatkan data produk dengan informasi tambahan
    public function getProductData($startDate = null, $endDate = null)
    {
        $query = DB::table('products')
            ->select('id', 'nama', 'harga',
                DB::raw('(SELECT SUM(quantity) FROM transaction_details WHERE product_id = products.id) as total_sold'),
                DB::raw('(SELECT COUNT(*) FROM transactions WHERE transactions.id IN (SELECT transaction_id FROM transaction_details WHERE product_id = products.id)) as total_transactions')
            );

        // Filter berdasarkan rentang tanggal transaksi
        if ($startDate && $endDate) {
            $query->whereExists(function ($subQuery) use ($startDate, $endDate) {
                $subQuery->select(DB::raw(1))
                    ->from('transactions')
                    ->join('transaction_details', 'transactions.id', '=', 'transaction_details.transaction_id')
                    ->whereRaw('transaction_details.product_id = products.id')
                    ->whereBetween('transactions.created_at', [$startDate, $endDate]);
            });
        }

        return $query->get();
    }

    // Normalisasi data
    private function normalizeData($products)
    {
        $maxTotalSold = $products->max('total_sold');
        $maxTotalTransactions = $products->max('total_transactions');
        $minHarga = $products->min('harga');

        foreach ($products as $product) {
            $product->normalized_harga = $minHarga / $product->harga;
            $product->normalized_total_sold = $product->total_sold / $maxTotalSold;
            $product->normalized_total_transactions = $product->total_transactions / $maxTotalTransactions;
        }

        return $products;
    }

    // Hitung skor SAW
    private function calculateScores($products)
    {
        $weights = [
            'harga' => 0.3,
            'total_sold' => 0.4,
            'total_transactions' => 0.3,
        ];

        foreach ($products as $product) {
            $product->score = ($product->normalized_harga * $weights['harga']) +
                              ($product->normalized_total_sold * $weights['total_sold']) +
                              ($product->normalized_total_transactions * $weights['total_transactions']);
        }

        return $products;
    }

    // Tampilkan data awal tanpa filter
    public function showInitialData()
    {
        $products = $this->getProductData();
        return view('pages.top_products.initial', ['products' => $products]);
    }

    // Tampilkan data setelah normalisasi
    public function showNormalizedData()
    {
        $products = $this->getProductData();
        $normalizedProducts = $this->normalizeData($products);

        return view('pages.top_products.normalized', ['products' => $normalizedProducts]);
    }

    // Tampilkan skor akhir dengan filter bulan/tahun atau tanggal
    public function showFinalScores(Request $request)
    {
        // Mendapatkan start_date dan end_date dari request, jika tidak ada, gunakan bulan ini
        $startDate = Carbon::parse($request->get('start_date', now()->startOfMonth()->format('Y-m-d')))->startOfDay();
        $endDate = Carbon::parse($request->get('end_date', now()->endOfMonth()->format('Y-m-d')))->endOfDay();

        // Ambil data produk dengan filter berdasarkan rentang tanggal
        $products = $this->getProductData($startDate, $endDate);

        // Normalisasi data
        $normalizedProducts = $this->normalizeData($products);

        // Hitung skor
        $finalProducts = $this->calculateScores($normalizedProducts);

        // Urutkan berdasarkan skor tertinggi
        $sortedProducts = $finalProducts->sortByDesc('score');

        // Berikan peringkat
        $rank = 1;
        foreach ($sortedProducts as $product) {
            $product->rank = $rank++;
        }

        $topProduct = $sortedProducts->first();

        // Kirim data ke view
        return view('pages.top_products.final', [
            'products' => $sortedProducts,
            'topProduct' => $topProduct,
            'startDate' => $startDate->format('Y-m-d'),
            'endDate' => $endDate->format('Y-m-d'),
        ]);
    }
}
