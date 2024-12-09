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
                <th>Total Harga</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $transaction)
                <tr>
                    <td>{{ $transaction->created_at->format('d-m-Y') }}</td>
                    <td>{{ $transaction->product->nama }}</td>
                    <td>{{ $transaction->quantity }}</td>
                    <td>Rp {{ number_format($transaction->total_price, 2) }}</td>
                    <td>{{ ucfirst($transaction->status) }}</td>
                </tr>
                @endforeach
        </tbody>
    </table>

    <h3>Total Pemasukan: Rp {{ number_format($totalIncome, 2) }}</h3>
</body>
</html>
