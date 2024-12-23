<!DOCTYPE html>
<html>
<head>
    <title>Struk Transaksi</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 8px; text-align: left; border: 1px solid #ddd; }
        h1, h3 { text-align: center; }
        p { margin: 5px 0; }
    </style>
</head>
<body>
    <h1>Struk Transaksi</h1>
    <p><strong>ID Transaksi:</strong> {{ $transaction->id }}</p>
    <p><strong>Tanggal:</strong> {{ $transaction->created_at->format('d-m-Y H:i') }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Produk</th>
                <th>Kategori</th>
                <th>Harga Satuan</th>
                <th>Jumlah</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @php $totalHarga = 0; @endphp
            @foreach ($transaction->details as $detail)
                @php
                    $subtotal = $detail->product->harga * $detail->quantity;
                    $totalHarga += $subtotal;
                @endphp
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $detail->product->nama }}</td>
                    <td>{{ $detail->product->category->name }}</td>
                    <td>Rp {{ number_format($detail->product->harga, 0, ',', '.') }}</td>
                    <td>{{ $detail->quantity }}</td>
                    <td>Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Total Harga: Rp {{ number_format($totalHarga, 0, ',', '.') }}</h3>

    <p>Terima kasih telah berbelanja!</p>
</body>
</html>
