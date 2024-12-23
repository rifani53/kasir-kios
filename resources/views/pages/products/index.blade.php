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

        <div class="card-body">
            {{-- Pesan sukses setelah operasi berhasil --}}
            @if (session('success'))
                <div class="alert alert-success text-center">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Tabel daftar produk --}}
            <table class="table table-striped table-hover text-center">
                <thead class="bg-secondary text-white">
                    <tr>
                        <th style="width: 5%;">No</th>
                        <th style="width: 20%;">Nama Produk</th>
                        <th style="width: 10%;">Jenis</th>
                        <th style="width: 10%;">Merek</th>
                        <th style="width: 10%;">Ukuran</th>
                        <th style="width: 10%;">Harga</th>
                        <th style="width: 5%;">Stok</th>
                        <th style="width: 10%;">Kategori</th>
                        <th style="width: 10%;">Satuan</th>
                        <th style="width: 15%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $product->nama }}</td>
                            <td>{{ $product->jenis }}</td>
                            <td>{{ $product->merek }}</td>
                            <td>{{ $product->ukuran }}</td>
                            <td>Rp {{ number_format($product->harga, 0, ',', '.') }}</td>
                            <td>{{ $product->stok }}</td>
                            <td>{{ $product->category->name }}</td>
                            <td>{{ $product->unit->name }}</td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    {{-- Tombol Edit --}}
                                    <a href="{{ route('pages.products.edit', $product->id) }}" 
                                       class="btn btn-warning btn-sm">
                                       <i class="fas fa-edit"></i> Edit
                                    </a>
                                    {{-- Tombol Hapus --}}
                                    <form action="{{ route('pages.products.destroy', $product->id) }}" 
                                          method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" 
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                                            <i class="fas fa-trash-alt"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="card-footer text-center bg-light">
            <p class="text-muted m-0">Daftar produk Anda akan tampil di sini</p>
        </div>
    </div>
</div>
@endsection
