@extends('layouts.main')

@section('content')
<div class="container mt-4">
    <h1>Riwayat Transaksi</h1>
    <!-- Form Pencarian -->
    <form method="GET" action="{{ route('pages.transactions.history') }}" class="mb-4">
        <div class="row">
            <div class="col-md-8">
                <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Cari produk atau kategori...">
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary w-100">Cari</button>
            </div>
        </div>
    </form>

    @if($transactions->isEmpty())
        <p>Tidak ada transaksi dalam riwayat.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Produk</th>
                    <th>Kasir</th>
                    <th>Jumlah</th>
                    <th>Total Harga</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transactions as $transaction)
            <tr>
                <td>{{ $transaction->id }}</td>
                <td>{{ $transaction->product->nama }}</td>
                <td>{{ $transaction->pengguna->name ?? 'Tidak Diketahui' }}</td>
                <td>{{ $transaction->quantity }}</td>
                <td>{{ number_format($transaction->subtotal, 0, ',', '.') }}</td>
                <td>{{ $transaction->created_at->format('d M Y') }}</td>
            </tr>
            @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
