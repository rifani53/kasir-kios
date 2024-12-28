<!DOCTYPE html>
<html>
<head>
    <title>Struk Transaksi - Kios Anis</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            color: #333;
            background-color: #f9f9f9;
        }
        .header, .footer {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            color: #2c3e50;
        }
        .header p {
            margin: 5px 0;
            font-size: 14px;
            color: #555;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #fff;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }
        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background-color: #2c3e50;
            color: #fff;
            text-transform: uppercase;
        }
        tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .total {
            text-align: right;
            font-weight: bold;
            font-size: 16px;
            margin-top: 20px;
        }
        .footer p {
            font-size: 14px;
            color: #555;
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>Kios Anis</h1>
        <p>Alamat: Desa Bluru, Kec. Batu Ampar, Kabupaten Tanah Laut</p>
        <p><strong>Struk Transaksi</strong></p>
    </div>

    <!-- Informasi Transaksi -->
    <p><strong>ID Transaksi:</strong> {{ $transaction->id }}</p>
    <p><strong>Tanggal:</strong> {{ $transaction->created_at->format('d-m-Y H:i') }}</p>

    <!-- Tabel Produk -->
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

    <!-- Total Harga -->
    <div class="total">
        <p>Total Harga: Rp {{ number_format($totalHarga, 0, ',', '.') }}</p>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>Terima kasih telah berbelanja di Kios Anis!</p>
    </div>
</body>
</html>
