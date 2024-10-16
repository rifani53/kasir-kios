@extends('layouts.main')

@section('content')
<div class="container">
    <h2>Daftar Produk</h2>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('pages.products.create') }}" class="btn btn-primary mb-3">Tambah Produk</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Produk</th>
                <th>Jenis</th> <!-- Pindahkan kolom Jenis di bawah Nama Produk -->
                <th>Merek</th> 
                <th>Ukuran</th> <!-- Pindahkan kolom Ukuran di bawah Nama Produk -->
                <th>Harga</th>
                <th>Stok</th>
                <th>Kategori</th>
                <th>Satuan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $product->nama }}</td>
                <td>{{ $product->jenis }}</td> <!-- Menampilkan Jenis Produk -->
                <td>{{ $product->merek }}</td>
                <td>{{ $product->ukuran }}</td> <!-- Menampilkan Ukuran Produk -->
                <td>Rp {{ number_format($product->harga, 0, ',', '.') }}</td>
                <td>{{ $product->stok }}</td>
                <td>{{ $product->category->name }}</td>
                <td>{{ $product->unit->name }}</td>
                <td>
                    <!-- Tombol Edit dan Delete -->
                    <form action="{{ route('pages.products.destroy', $product->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">Hapus</button>
                    </form>
                    <a href="{{ route('pages.products.edit', $product->id) }}" class="btn btn-warning">Edit</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
