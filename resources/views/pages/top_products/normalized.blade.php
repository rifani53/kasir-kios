@extends('layouts.main')

@section('content')
<div class="container">
    <div class="mt-1">
        <a href="{{ route('pages.top_products.initial') }}" class="btn btn-primary">Data Awal</a>
        <a href="{{ route('pages.top_products.normalized') }}" class="btn btn-secondary">Data Normalisasi</a>
        <a href="{{ route('pages.top_products.final') }}" class="btn btn-success">Skor Akhir</a>
    </div>
    <h2 class="text-center">Data Normalisasi</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama Produk</th>
                <th>Harga (Ternormalisasi)</th>
                <th>Jumlah Terjual (Ternormalisasi)</th>
                <th>Jumlah Transaksi (Ternormalisasi)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
            <tr>
                <td>{{ $product->nama }}</td>
                <td>{{ number_format($product->normalized_harga, 2) }}</td>
                <td>{{ number_format($product->normalized_total_sold, 2) }}</td>
                <td>{{ number_format($product->normalized_total_transactions, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
