@extends('layouts.main')

@section('content')
<div class="container">
    <div class="mt-1">
        <a href="{{ route('pages.top_products.initial') }}" class="btn btn-primary">Data Awal</a>
        <a href="{{ route('pages.top_products.normalized') }}" class="btn btn-secondary">Perhitungan</a>
        <a href="{{ route('pages.top_products.final') }}" class="btn btn-success">Hasil Akhir</a>
        <h2 class="text-center">Data Awal Produk</h2>

        <!-- Tabel Data Produk -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama Produk</th>
                    <th>Harga</th>
                    <th>Jumlah Terjual</th>
                    <th>Jumlah Transaksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                <tr>
                    <td>{{ $product->nama }}</td>
                    <td>Rp {{ number_format($product->harga, 0, ',', '.') }}</td>
                    <td>{{ $product->total_sold }}</td>
                    <td>{{ $product->total_transactions }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endsection
    