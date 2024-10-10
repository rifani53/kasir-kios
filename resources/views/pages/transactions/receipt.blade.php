<!-- resources/views/transactions/receipt.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <title>Struk Transaksi</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        .receipt {
            max-width: 600px;
            margin: auto;
            padding: 20px;
            border: 1px solid #333;
        }
        .receipt h2 { text-align: center; }
        .receipt table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .receipt table, .receipt th, .receipt td { border: 1px solid #333; }
        .receipt th, .receipt td { padding: 10px; text-align: left; }
        .receipt .total { text-align: right; }
    </style>
</head>
<body>
    <div class="receipt">
        <h2>Struk Transaksi</h2>
        <p><strong>ID Transaksi:</strong> {{ $transaction->id }}</p>
        <p><strong>Produk:</strong> {{ $transaction->product->nama }}</p>
        <p><strong>Kategori:</strong> {{ $transaction->product->category->name }}</p>
        <p><strong>Jumlah:</strong> {{ $transaction->quantity }}</p>
        <p><strong>Total Harga:</strong> Rp {{ number_format($transaction->total_price, 2) }}</p>
        <p><strong>Status:</strong> {{ ucfirst($transaction->status) }}</p>
        <p><strong>Tanggal:</strong> {{ $transaction->created_at->format('d-m-Y H:i') }}</p>
        <hr>
        <p>Terima kasih atas kunjungan Anda!</p>
    </div>
</body>
</html>
