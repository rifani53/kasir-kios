<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;

class Perinkingancontroller extends Controller
{
    // Mendapatkan data produk dengan informasi tambahan dan filter bulan/tahun
    public function getProductData(Request $request)
    {
        // Ambil bulan dan tahun dari request
        $month = $request->input('month');
        $year = $request->input('year');

        $query = DB::table('products')
            ->select('id', 'nama', 'harga',
                DB::raw('(SELECT SUM(quantity) FROM transaction_details WHERE product_id = products.id) as total_sold'),
                DB::raw('(SELECT COUNT(*) FROM transactions WHERE transactions.id IN (SELECT transaction_id FROM transaction_details WHERE product_id = products.id)) as total_transactions')
            );

        // Filter berdasarkan bulan dan tahun jika ada
        if ($month && $year) {
            $query->whereIn('id', function ($subquery) use ($month, $year) {
                $subquery->select('product_id')
                    ->from('transaction_details')
                    ->whereIn('transaction_id', function ($subsubquery) use ($month, $year) {
                        $subsubquery->select('id')
                            ->from('transactions')
                            ->whereMonth('created_at', $month)
                            ->whereYear('created_at', $year);
                    });
            });
        }

        return $query->get();
    }

    // Normalisasi data
    private function normalizeData($products)
    {
        // Cari nilai maksimum dan minimum untuk setiap kriteria
        $maxTotalSold = $products->max('total_sold');
        $maxTotalTransactions = $products->max('total_transactions');
        $minHarga = $products->min('harga'); // Untuk kriteria cost

        // Normalisasi setiap produk
        foreach ($products as $product) {
            // Normalisasi harga sebagai cost
            $product->normalized_harga = $minHarga / $product->harga;

            // Normalisasi lainnya sebagai benefit
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

        // Hitung skor untuk setiap produk
        foreach ($products as $product) {
            $product->score = ($product->normalized_harga * $weights['harga']) +
                              ($product->normalized_total_sold * $weights['total_sold']) +
                              ($product->normalized_total_transactions * $weights['total_transactions']);
        }

        return $products;
    }

    // Langkah 1: Tampilkan data awal
    public function showInitialData(Request $request)
    {
        $products = $this->getProductData($request);
        return view('pages.top_products.initial', ['products' => $products]);
    }

    // Langkah 2: Tampilkan data setelah normalisasi
    public function showNormalizedData(Request $request)
    {
        $products = $this->getProductData($request);
        $normalizedProducts = $this->normalizeData($products);

        return view('pages.top_products.normalized', ['products' => $normalizedProducts]);
    }

    // Langkah 3: Tampilkan skor akhir
    public function showFinalScores(Request $request)
    {
        $products = $this->getProductData($request);
        $normalizedProducts = $this->normalizeData($products);
        $finalProducts = $this->calculateScores($normalizedProducts);

        // Urutkan data berdasarkan skor akhir (terbesar ke terkecil)
        $sortedProducts = $finalProducts->sortByDesc('score');

        // Menambahkan peringkat berdasarkan urutan skor
        $rank = 1;
        foreach ($sortedProducts as $product) {
            $product->rank = $rank++;
        }

        // Kirim data yang sudah diurutkan dan diberi peringkat ke view
        return view('pages.top_products.final', ['products' => $sortedProducts]);
    }
}
