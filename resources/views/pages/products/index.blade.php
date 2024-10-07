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
                <th>Harga</th>
                <th>Stok</th>
                <th>Kategori</th>
                <th>Aksi</th> <!-- Tambahkan kolom Aksi -->
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $product->nama }}</td>
                <td>Rp {{ number_format($product->harga, 0, ',', '.') }}</td> <!-- Format harga -->
                <td>{{ $product->stok }}</td>
                <td>{{ $product->category->name }}</td>
                <td>
                    <!-- Tombol Edit dan Delete -->
                    <form action="{{ route('pages.products.destroy', $product->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE') <!-- Method DELETE untuk menghapus -->
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
