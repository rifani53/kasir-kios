@extends('layouts.main')

@section('content')
<div class="container mt-4">
    <h1>Transaksi Sukses</h1>

    <p><strong>ID Transaksi:</strong> {{ $transaction->id }}</p>
    <p><strong>Tanggal:</strong> {{ $transaction->created_at->format('d-m-Y H:i') }}</p>

    <table class="table table-bordered">
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

    <!-- Tombol untuk Print dan Download PDF -->
    <div class="print-btn">
        <button onclick="window.print()" class="btn btn-primary">Print Struk</button>
        <a href="{{ route('transactions.downloadReceipt', $transaction->id) }}" class="btn btn-success">Download PDF</a>
        <a href="{{ route('pages.transactions.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
</div>
@endsection
