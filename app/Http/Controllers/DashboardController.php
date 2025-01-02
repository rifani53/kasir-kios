<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\TransactionDetail;

class DashboardController extends Controller
{
    public function index()
    {
        // Total Penjualan
        $totalSales = TransactionDetail::sum('subtotal');

        // Penjualan Bulanan
        $monthlySales = TransactionDetail::selectRaw('MONTH(created_at) as month, SUM(subtotal) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');

        // Transaksi Terbaru
        $recentTransactions = TransactionDetail::orderBy('created_at', 'desc')
            ->take(5)
            ->get(['id', 'subtotal', 'quantity', 'created_at']);

        // Pendapatan Hari Ini
        $todayRevenue = TransactionDetail::whereDate('created_at', Carbon::today())->sum('subtotal');

        // Stok Tersedia
        $totalStock = Product::sum('stok');

        // Total Transaksi Hari Ini
        $totalTransactionsToday = TransactionDetail::whereDate('created_at', Carbon::today())->count();

        // Produk Terlaris berdasarkan Quantity
        $bestSellingProducts = TransactionDetail::selectRaw('product_id, SUM(quantity) as total_quantity, SUM(subtotal) as total_sales')
            ->groupBy('product_id')
            ->orderByDesc('total_quantity')
            ->take(5)
            ->get();

        // Mengirim data ke view
        return view('pages.dashboard.index', [
            'totalSales' => $totalSales,
            'monthlySales' => $monthlySales,
            'recentTransactions' => $recentTransactions,
            'todayRevenue' => $todayRevenue,
            'totalStok' => $totalStock,
            'totalTransactionsToday' => $totalTransactionsToday,
            'bestSellingProducts' => $bestSellingProducts,
        ]);
    }
}
