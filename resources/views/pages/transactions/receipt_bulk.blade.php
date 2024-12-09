<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Struk Transaksi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        .total {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h3>Struk Transaksi</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Produk</th>
                <th>Kategori</th>
                <th>Jumlah</th>
                <th>Total Harga</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transactions as $index => $transaction)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $transaction['product_name'] }}</td>
                    <td>{{ $transaction['category'] }}</td>
                    <td>{{ $transaction['quantity'] }}</td>
                    <td>Rp {{ number_format($transaction['total_price'], 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <p class="total">Total Keseluruhan: Rp {{ number_format(array_sum(array_column($transactions, 'total_price')), 0, ',', '.') }}</p>
</body>
</html>
