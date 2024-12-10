<!DOCTYPE html>
<html>
<head>
    <title>Laporan Transaksi</title>
</head>
<body>
    <h1>Laporan Transaksi</h1>
    <p>Periode: {{ $startDate }} hingga {{ $endDate }}</p>

    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Produk</th>
                <th>Jumlah</th>
                <th>harga satuan</th>
                <th>Total Harga</th>
            </tr>
        </thead>
        <tbody>
            @foreach($details as $detail)
            <tr>
                <td>{{ $detail->created_at->format('d-m-Y') }}</td>
                <td>{{ $detail->product->nama ?? '-' }}</td>
                <td>{{ $detail->quantity }}</td>
                <td>Rp {{ number_format($detail->product->harga ?? 0, 2, ',', '.') }}</td>
                <td>Rp {{ number_format($detail->quantity * ($detail->product->harga ?? 0), 2, ',', '.') }}</td>
            </tr>
                @endforeach
        </tbody>
    </table>

    <h3>Total Pemasukan: Rp {{ number_format($totalIncome, 2) }}</h3>
</body>
</html>
