@extends('layouts.main')

    @section('header')
<div class="row mb-2 justify-content-center">
    <div class="col-md-8 text-center">
        <h1>Laporan Transaksi</h1>
    </div>
</div>

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

    <!-- Total Pemasukan -->
    <div class="row mb-3">
        <div class="col-md-8 d-flex align-items-center">
            <!-- Tombol Export -->
            <form method="POST" action="{{ route('pages.laporan.export') }}" class="d-inline">
                @csrf
                <input type="hidden" name="start_date" value="{{ $startDate }}">
                <input type="hidden" name="end_date" value="{{ $endDate }}">
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-file-export"></i> Export Laporan
                </button>
            </form>
        </div>
        <div class="col-md-4 text-end">
            <h3 class="m-0">Total Pemasukan:</h3>
            <h3 class="text-success">Rp {{ number_format($totalIncome, 2, ',', '.') }}</h3>
        </div>
    </div>

    <!-- Data Transaksi -->
    @if($details->isEmpty())
        <div class="alert alert-warning text-center">Tidak ada transaksi pada periode ini.</div>
    @else
        <table class="table table-bordered table-striped">
            <thead class="bg-primary text-white">
                <tr class="text-center">
                    <th>Tanggal</th>
                    <th>Produk</th>
                    <th>Jumlah</th>
                    <th>Harga Satuan</th>
                    <th>Total Harga</th>
                </tr>
            </thead>
            <tbody>
                @foreach($details as $detail)
                <tr class="text-center">
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
</div>
@endsection
