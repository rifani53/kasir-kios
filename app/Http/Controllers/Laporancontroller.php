<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\TransactionExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Transaction;

class Laporancontroller extends Controller
{
    public function index(Request $request)
    {
        // Filter laporan berdasarkan tanggal
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $transactions = Transaction::with('product')
            ->when($startDate, function ($query) use ($startDate) {
                $query->whereDate('created_at', '>=', $startDate);
            })
            ->when($endDate, function ($query) use ($endDate) {
                $query->whereDate('created_at', '<=', $endDate);
            })
            ->get();

        $totalIncome = $transactions->sum('total_price');

        return view('pages.laporan.index', compact('transactions', 'totalIncome', 'startDate', 'endDate'));
    }

    public function export(Request $request)
    {
        // Validasi input tanggal
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        // Ambil input tanggal
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Ekspor ke file Excel
        return Excel::download(new TransactionExport($startDate, $endDate), 'laporan-transaksi.xlsx');
    }
}
