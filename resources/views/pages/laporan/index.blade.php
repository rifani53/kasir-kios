@extends('layouts.main')

@section('content')
<div class="container">
    <h1>Laporan Transaksi</h1>

    <!-- Filter Laporan -->
    <form method="GET" action="{{ route('pages.laporan.index') }}" class="mb-4">
        <div class="row">
            <div class="col-md-4">
                <label for="start_date">Tanggal Mulai:</label>
                <input type="date" name="start_date" id="start_date" class="form-control" value="{{ $startDate }}">
            </div>
            <div class="col-md-4">
                <label for="end_date">Tanggal Selesai:</label>
                <input type="date" name="end_date" id="end_date" class="form-control" value="{{ $endDate }}">
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </div>
    </form>

    <!-- Data Transaksi -->
    <h2>Data Transaksi</h2>
    @if($transactions->isEmpty())
        <p>Tidak ada transaksi pada periode ini.</p>
    @else
        <table class="table table-bordered">
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
    @endif

    <!-- Total Pemasukan -->
    <h3>Total Pemasukan: Rp {{ number_format($totalIncome, 2) }}</h3>

    <!-- Tombol Export -->
    <form method="POST" action="{{ route('pages.laporan.export') }}">
        @csrf
        <input type="hidden" name="start_date" value="{{ $startDate }}">
        <input type="hidden" name="end_date" value="{{ $endDate }}">
        <button type="submit" class="btn btn-success">Export Laporan</button>
    </form>
</div>
@endsection
