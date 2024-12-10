@extends('layouts.main')

@section('content')
<div class="container">
    <div class="mt-1">
        <a href="{{ route('pages.top_products.initial') }}" class="btn btn-primary">Data Awal</a>
        <a href="{{ route('pages.top_products.normalized') }}" class="btn btn-secondary">Data Normalisasi</a>
        <a href="{{ route('pages.top_products.final') }}" class="btn btn-success">Skor Akhir</a>
        <div class="mt-1 mb-3">
            <a href="{{ route('pages.top_products.final', ['month' => $month - 1, 'year' => $year]) }}" class="btn btn-light">
                &lt; Bulan Sebelumnya
            </a>
            <a href="{{ route('pages.top_products.final', ['month' => $month + 1, 'year' => $year]) }}" class="btn btn-light">
                Bulan Berikutnya &gt;
            </a>
        </div>
    
        <!-- Header Halaman -->
        <h2 class="text-center">Produk Terbaik - {{ \Carbon\Carbon::create($year, $month)->format('F Y') }}</h2>
    
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