<?php

namespace App\Exports;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Carbon\Carbon;

class TransactionExport implements FromCollection
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate, $endDate)
    {
        // Parse tanggal untuk memastikan format yang benar
        $this->startDate = Carbon::parse($startDate)->startOfDay();
        $this->endDate = Carbon::parse($endDate)->endOfDay();

     
    }

    public function collection()
    {
        // Ambil data transaksi dengan relasi produk
        $transactions = Transaction::with('product')
            ->whereBetween('created_at', [$this->startDate, $this->endDate])
            ->get();
        // Mapping data transaksi untuk diexport
        $mappedTransactions = $transactions->map(function ($transaction) {
            return [
                'Tanggal' => $transaction->created_at->format('d-m-Y'),
                'Produk' => $transaction->product->nama ?? 'Tidak Ada', // Menangani jika tidak ada produk
                'Jumlah' => $transaction->quantity,
                'Total Harga' => $transaction->total_price,
                'Status' => ucfirst($transaction->status),
            ];
        });

        // Gabungkan header dan data transaksi
        $header = [['Tanggal', 'Produk', 'Jumlah', 'Total Harga', 'Status']];
        $data = $mappedTransactions->toArray();

        return collect(array_merge($header, $data)); // Menggabungkan header dan data transaksi
    }
}
