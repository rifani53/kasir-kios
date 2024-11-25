<?php

namespace App\Exports;

use App\Models\Transaction;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class TransactionExport implements FromCollection
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        $transactions = Transaction::with('product')
            ->whereBetween('created_at', [$this->startDate, $this->endDate])
            ->get()
            ->map(function ($transaction) {
                return [
                    'Tanggal' => $transaction->created_at->format('d-m-Y'),
                    'Produk' => $transaction->product->nama ?? 'Tidak Ada',
                    'Jumlah' => $transaction->quantity,
                    'Total Harga' => $transaction->total_price,
                    'Status' => ucfirst($transaction->status),
                ];
            });

        return collect(array_merge(
            [['Tanggal', 'Produk', 'Jumlah', 'Total Harga', 'Status']], // Header
            $transactions->toArray()
        ));
    }
}
