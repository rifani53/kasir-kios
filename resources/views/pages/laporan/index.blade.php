@extends('layouts.main')

@section('content')
<div class="container">
    <h1>Laporan Transaksi</h1>

    <!-- Filter Laporan -->
    <form method="GET" action="{{ route('pages.laporan.index') }}" class="mb-4">
        <div class="row">
            <div class="col-md-4">
                <label for="start_date">Tanggal Mulai</label>
                <input type="date" id="start_date" name="start_date" class="form-control" value="{{ request('start_date', $startDate) }}">
            </div>
            <div class="col-md-4">
                <label for="end_date">Tanggal Akhir</label>
                <input type="date" id="end_date" name="end_date" class="form-control" value="{{ request('end_date', $endDate) }}">
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </div>
    </form>
    
    <!-- Data Transaksi -->
    <h2>Data Transaksi</h2>
    @if($details->isEmpty())
        <p>Tidak ada transaksi pada periode ini.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Produk</th>
                    <th>Jumlah</th>
                    <th>Harga Satuan</th>
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
    @endif

    <!-- Total Pemasukan -->
    <h3>Total Pemasukan: Rp {{ number_format($totalIncome, 2, ',', '.') }}</h3>

    <!-- Tombol Export -->
    <form method="POST" action="{{ route('pages.laporan.export') }}">
        @csrf
        <input type="hidden" name="start_date" value="{{ $startDate }}">
        <input type="hidden" name="end_date" value="{{ $endDate }}">
        <button type="submit" class="btn btn-success">Export Laporan</button>
    </form>
</div>
@endsection
