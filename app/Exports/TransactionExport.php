<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use App\Models\TransactionDetail;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TransactionExport implements FromCollection, WithHeadings, WithStyles, WithCalculatedFormulas
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
        // Get the transaction details based on the date range
        $details = TransactionDetail::whereBetween('created_at', [$this->startDate, $this->endDate])
            ->with(['transaction', 'product'])
            ->get();

        $exportData = $details->map(function ($detail) {
            // Calculate total price for each transaction detail
            $totalPrice = $detail->quantity * ($detail->product->harga ?? 0);
            return [
                'date' => $detail->created_at->format('d-m-Y'), // Transaction date
                'product' => $detail->product->nama, // Product name
                'quantity' => $detail->quantity, // Quantity purchased
                'unit_price' => $this->formatRupiah($detail->product->harga), // Unit price
                'total_price' => $this->formatRupiah($totalPrice), // Total price
            ];
        });

        // Add a row for the total income
        $totalIncome = $details->sum(function ($detail) {
            return $detail->quantity * ($detail->product->harga ?? 0);
        });

        $exportData->push([
            'date' => '',
            'product' => '',
            'quantity' => '',
            'unit_price' => '',
            'total_price' => 'Total Pemasukkan: ' . $this->formatRupiah($totalIncome),
        ]);

        return $exportData;
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Produk',
            'Jumlah',
            'Harga Satuan',
            'Total Harga',
        ];
    }

    // Format numbers as Rupiah
    private function formatRupiah($amount)
    {
        return 'Rp ' . number_format($amount, 2, ',', '.');
    }

    public function styles(Worksheet $sheet)
    {
        // Style the header with a soft background color
        $sheet->getStyle('A1:E1')->getFont()->setBold(true)->setSize(12);
        $sheet->getStyle('A1:E1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1:E1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('A9D08E'); // Soft green background

        // Apply moderate border thickness to all cells
        $sheet->getStyle('A1:E' . ($sheet->getHighestRow()))->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);

        // Apply alternating row colors with soft tones
        $rows = $sheet->getRowIterator();
        $isEven = true;
        foreach ($rows as $row) {
            $rowIndex = $row->getRowIndex();
            if ($rowIndex > 1) { // Skip the header row
                $color = $isEven ? 'F9F9F9' : 'FFFFFF'; // Soft gray for even rows, white for odd
                $sheet->getStyle("A$rowIndex:E$rowIndex")->applyFromArray([
                    'fill' => [
                        'type' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => ['rgb' => $color],
                    ],
                ]);
                $isEven = !$isEven;
            }
        }

        // Total row styling
        $sheet->getStyle('A' . ($sheet->getHighestRow()) . ':E' . ($sheet->getHighestRow()))->getFont()->setBold(true);
        $sheet->getStyle('A' . ($sheet->getHighestRow()) . ':E' . ($sheet->getHighestRow()))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A' . ($sheet->getHighestRow()) . ':E' . ($sheet->getHighestRow()))->getFont()->getColor()->setRGB('FF9900'); // Soft orange for the total row

        // Auto size columns based on content
        foreach (range('A', 'E') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }
    }
}
