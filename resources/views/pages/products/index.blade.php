@extends('layouts.main')

@section('header')
<div class="row mb-2 justify-content-center">
    <div class="col-md-8 text-center">
        <h1>Daftar Produk</h1>
    </div>
</div>
@endsection

@section('content')
<div class="d-flex justify-content-center">
    <div class="card shadow-lg" style="width: 90%; border-radius: 10px;">
        <div class="card-header bg-primary text-white text-center" style="border-radius: 10px 10px 0 0;">
            
            <div class="card-tools">
                <a href="{{ route('pages.products.create') }}" class="btn btn-light btn-sm">+ Tambah Produk</a>
            </div>
        </div>
        <!-- Body Card -->
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success text-center">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Tabel Produk -->
            <table class="table table-bordered table-striped text-center">
                <thead class="thead-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama Produk</th>
                        
                        <th>Merek</th>
                        <th>Ukuran</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Kategori</th>
                        <th>Satuan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $product)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $product->nama }}</td>
                            <td>{{ $product->merek }}</td>
                            <td>{{ $product->ukuran }}</td>
                            <td>Rp {{ number_format($product->harga, 0, ',', '.') }}</td>
                            <td>{{ $product->stok }}</td>
                            <td>{{ $product->category->name }}</td>
                            <td>{{ $product->unit->name }}</td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('pages.products.edit', $product->id) }}" class="btn btn-warning btn-sm mr-1">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('pages.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash-alt"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center">Tidak ada data produk</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Footer Card -->
        <div class="card-footer text-center bg-light">
            <p class="text-muted mb-0">Total produk: {{ $products->count() }}</p>
        </div>
    </div>
</div>
@endsection
