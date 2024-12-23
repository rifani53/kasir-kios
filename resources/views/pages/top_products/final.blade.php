@extends('layouts.main')

@section('content')
<div class="container">
    <div class="mt-1">
        <a href="{{ route('pages.top_products.initial') }}" class="btn btn-primary">Data Awal</a>
        <a href="{{ route('pages.top_products.normalized') }}" class="btn btn-secondary">Perhitungan</a>
        <a href="{{ route('pages.top_products.final') }}" class="btn btn-success">Hasil Akhir</a>

        <form method="GET" action="{{ route('pages.top_products.final') }}" class="mb-4">
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
    
    
        <!-- Produk Terbaik -->
        @if ($topProduct)
        <div class="alert alert-success text-center">
            <h4>Produk Terbaik: {{ $topProduct->nama }}</h4>
            <p>Skor Akhir: {{ number_format($topProduct->score, 2) }}</p>
            <p>Harga: Rp {{ number_format($topProduct->harga, 0, ',', '.') }}</p>
            <p>Total Terjual: {{ $topProduct->total_sold }}</p>
            <p>Jumlah Transaksi: {{ $topProduct->total_transactions }}</p>
        </div>
        @endif
    
        <!-- Tabel Peringkat -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Peringkat</th>
                    <th>Nama Produk</th>
                    <th>Harga</th>
                    <th>Total Terjual</th>
                    <th>Jumlah Transaksi</th>
                    <th>Skor Akhir</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                <tr>
                    <td>{{ $product->rank }}</td>
                    <td>{{ $product->nama }}</td>
                    <td>Rp {{ number_format($product->harga, 0, ',', '.') }}</td>
                    <td>{{ $product->total_sold }}</td>
                    <td>{{ $product->total_transactions }}</td>
                    <td>{{ number_format($product->score, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endsection