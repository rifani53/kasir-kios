<?php

namespace App\Exports;

use App\Models\TransactionDetail;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Events\AfterSheet;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TransactionExport implements FromCollection, WithHeadings, WithStyles, WithEvents, ShouldAutoSize
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = Carbon::parse($startDate)->startOfDay();
        $this->endDate = Carbon::parse($endDate)->endOfDay();
    }

    public function collection()
    {
        $transactions = TransactionDetail::with('transaction', 'product')
            ->whereHas('transaction', function ($query) {
                $query->whereBetween('created_at', [$this->startDate, $this->endDate]);
            })
            ->get();

        $mappedTransactions = $transactions->map(function ($transaction) {
            return [
                'Tanggal' => $transaction->transaction->created_at->format('d-m-Y'),
                'Produk' => $transaction->product->nama ?? 'Tidak Ada',
                'Jumlah' => $transaction->quantity,
                'Harga Satuan' => $this->formatRupiah($transaction->product->harga ?? 0),
                'Total Harga' => $this->formatRupiah($transaction->quantity * ($transaction->product->harga ?? 0)),
                'Status' => ucfirst($transaction->transaction->status),
            ];
        });

        $totalIncome = $transactions->sum(function ($transaction) {
            return $transaction->quantity * ($transaction->product->harga ?? 0);
        });

        $mappedTransactions->push([
            'Tanggal' => '',
            'Produk' => '',
            'Jumlah' => '',
            'Harga Satuan' => '',
            'Total Harga' => $this->formatRupiah($totalIncome),
            'Status' => 'Total Pemasukan',
        ]);

        return $mappedTransactions;
    }

    public function headings(): array
    {
        return ['Tanggal', 'Produk', 'Jumlah', 'Harga Satuan', 'Total Harga', 'Status'];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]], // Header bold
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Auto-size kolom
                foreach (range('A', $sheet->getHighestDataColumn()) as $col) {
                    $sheet->getColumnDimension($col)->setAutoSize(true);
                }

                // Header style (warna dan garis tebal)
                $sheet->getStyle('A1:F1')->applyFromArray([
                    'font' => ['bold' => true],
                    'fill' => [
                        'fillType' => 'solid',
                        'startColor' => ['rgb' => 'FFD700'], // Warna header (gold)
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                            'color' => ['rgb' => '000000'], // Warna border (hitam)
                        ],
                    ],
                ]);

                // Seluruh tabel (garis tebal)
                $sheet->getStyle('A1:' . $sheet->getHighestColumn() . $sheet->getHighestRow())
                    ->applyFromArray([
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                                'color' => ['rgb' => '000000'], // Warna border (hitam)
                            ],
                        ],
                    ]);
            },
        ];
    }

    private function formatRupiah($value)
    {
        return 'Rp ' . number_format($value, 2, ',', '.');
    }
}
