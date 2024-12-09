@extends('layouts.main')

@section('content')
<div class="container">
    <div class="mt-1">
        <a href="{{ route('pages.top_products.initial') }}" class="btn btn-primary">Data Awal</a>
        <a href="{{ route('pages.top_products.normalized') }}" class="btn btn-secondary">Data Normalisasi</a>
        <a href="{{ route('pages.top_products.final') }}" class="btn btn-success">Skor Akhir</a>
    </div>
    <h2 class="text-center">Data Awal Produk</h2>
    <!-- Form Filter berdasarkan bulan dan tahun -->
    <form method="GET" action="{{ route('pages.top_products.initial') }}" class="mb-3">
        <div class="row">
            <div class="col-md-3">
                <select name="month" class="form-control">
                    <option value="" disabled selected>Pilih Bulan</option>
                    @foreach (range(1, 12) as $month)
                        <option value="{{ $month }}" {{ request()->month == $month ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::create()->month($month)->format('F') }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select name="year" class="form-control">
                    <option value="" disabled selected>Pilih Tahun</option>
                    @foreach (range(date('Y'), 2000) as $year)
                        <option value="{{ $year }}" {{ request()->year == $year ? 'selected' : '' }}>
                            {{ $year }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </div>
    </form>

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
