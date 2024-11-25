<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Exports\TransactionExport;
use Maatwebsite\Excel\Facades\Excel;

class Laporancontroller extends Controller
{
    public function index(Request $request)
    {
        // Ambil parameter tanggal dari input
        $startDate = $request->get('start_date', now()->subMonth()->toDateString());
        $endDate = $request->get('end_date', now()->toDateString());

        // Ambil transaksi berdasarkan tanggal yang diberikan
        $transactions = Transaction::with('product')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();

        // Hitung total pemasukan
        $totalIncome = $transactions->sum('total_price');

        // Kembalikan view dengan data transaksi dan total pemasukan
        return view('pages.laporan.index', compact('transactions', 'totalIncome', 'startDate', 'endDate'));
    }

    public function export(Request $request)
    {
        // Ambil parameter tanggal dari input
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');

        // Mengekspor data transaksi ke Excel
        return Excel::download(new TransactionExport($startDate, $endDate), 'laporan_transaksi.xlsx');
    }
}
