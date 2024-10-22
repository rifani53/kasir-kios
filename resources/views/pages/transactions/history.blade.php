@extends('layouts.main')

@section('content')
<div class="container mt-4">
    <h1>Riwayat Transaksi</h1>

    @if($transactions->isEmpty())
        <p>Tidak ada transaksi dalam riwayat.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Produk</th>
                    <th>Jumlah</th>
                    <th>Total Harga</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transactions as $transaction)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $transaction->product->nama }}</td>
                    <td>{{ $transaction->quantity }}</td>
                    <td>Rp {{ number_format($transaction->total_price, 2) }}</td>
                    <td>
                        <span class="badge
                            {{ $transaction->status === 'completed' ? 'bg-success' : ($transaction->status === 'cancelled' ? 'bg-danger' : 'bg-warning') }}">
                            {{ ucfirst($transaction->status) }}
                        </span>
                    </td>
                    <td>{{ $transaction->created_at->format('d-m-Y H:i:s') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
