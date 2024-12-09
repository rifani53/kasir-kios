<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\TransactionExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\TransactionDetail;
use Carbon\Carbon;

class Laporancontroller extends Controller
{
    public function index(Request $request)
    {
        // Ambil tanggal awal dan akhir dari request, default ke bulan ini
        $startDate = Carbon::parse($request->get('start_date', now()->startOfMonth()->format('Y-m-d')))->startOfDay();
        $endDate = Carbon::parse($request->get('end_date', now()->endOfMonth()->format('Y-m-d')))->endOfDay();

        // Ambil detail transaksi langsung berdasarkan tanggal di tabel TransactionDetail
        $details = TransactionDetail::whereBetween('created_at', [$startDate, $endDate])
            ->with(['transaction', 'product']) // Ambil relasi yang diperlukan
            ->get();

        // Hitung total pendapatan
        $totalIncome = $details->sum(function ($detail) {
            return $detail->quantity * ($detail->product->harga ?? 0);
        });

        // Return ke view dengan data transaksi
        return view('pages.laporan.index', [
            'details' => $details,
            'startDate' => $startDate->format('Y-m-d'),
            'endDate' => $endDate->format('Y-m-d'),
            'totalIncome' => $totalIncome,
        ]);
    }

    public function export(Request $request)
    {
        // Validasi input tanggal
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        // Ambil tanggal awal dan akhir
        $startDate = Carbon::parse($request->input('start_date'))->startOfDay();
        $endDate = Carbon::parse($request->input('end_date'))->endOfDay();

        // Ekspor ke file Excel
        return Excel::download(new TransactionExport($startDate, $endDate), 'laporan-transaksi.xlsx');
    }
} 