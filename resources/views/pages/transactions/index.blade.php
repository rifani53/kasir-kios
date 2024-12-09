@extends('layouts.main')

@section('content')
<div class="container">
    <h1>Daftar Produk</h1>

    <!-- Form Filter dan Pencarian -->
    <form method="GET" action="{{ route('pages.transactions.index') }}" class="mb-4">
        <div class="row">
            {{-- Pencarian --}}
            <div class="col-md-6">
                <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Cari produk atau kategori...">
            </div>

            {{-- Filter Kategori --}}
            <div class="col-md-4">
                <select name="category" class="form-control">
                    <option value="">Semua Kategori</option>
                    @foreach ($categories as $id => $name)
                        <option value="{{ $id }}" {{ $selectedCategoryId == $id ? 'selected' : '' }}>
                            {{ $name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Tombol Filter --}}
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
            </div>
        </div>
    </form>

    <!-- Tautan ke halaman Cart -->
    <div class="mb-3">
        <a href="{{ route('cart.show') }}" class="btn btn-primary">
            <i class="fas fa-shopping-cart"></i> Lihat Keranjang
        </a>
    </div>

    <!-- Tabel Daftar Produk -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama Produk</th>
                <th>Kategori</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($products as $product)
                <tr>
                    <td>{{ $product->nama }}</td>
                    <td>{{ $product->category->name }}</td>
                    <td>Rp {{ number_format($product->harga, 0, ',', '.') }}</td>
                    <td>{{ $product->stok }}</td>
                    <td>
                        @if ($product->stok > 0)
                            <form action="{{ route('cart.add') }}" method="POST" style="display: inline;">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="number" name="quantity" value="1" min="1" max="{{ $product->stok }}" class="form-control mb-2" style="width: 80px; display: inline;">
                                <button type="submit" class="btn btn-success btn-sm">Tambah ke Keranjang</button>
                            </form>
                        @else
                            <span class="text-danger">Stok Habis</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Tidak ada produk ditemukan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
