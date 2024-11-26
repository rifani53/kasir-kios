<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\TransactionExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\TransactionDetail;

class Laporancontroller extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->get('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->endOfMonth()->format('Y-m-d'));
    
        $details = TransactionDetail::with(['transaction', 'product'])
            ->whereHas('transaction', function ($query) use ($startDate, $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            })
            ->get();
    
        $totalIncome = $details->sum(function ($detail) {
            return $detail->quantity * ($detail->product->harga ?? 0);
        });
    
        return view('pages.laporan.index', compact('details', 'startDate', 'endDate', 'totalIncome'));
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
