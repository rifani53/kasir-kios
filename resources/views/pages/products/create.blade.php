@extends('layouts.main')

@section('header')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1>Tambah Produk</h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('pages.products.index') }}">Produk</a></li>
            <li class="breadcrumb-item active">Tambah Produk</li>
        </ol>
    </div>
</div>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Form Tambah Produk</h3>
    </div>
    <div class="card-body">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('pages.products.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="nama">Nama Produk</label>
                <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror" required>
                @error('nama')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="harga">Harga</label>
                <input type="number" name="harga" id="harga" class="form-control @error('harga') is-invalid @enderror" required>
                @error('harga')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="stok">Stok</label>
                <input type="number" name="stok" id="stok" class="form-control @error('stok') is-invalid @enderror" required>
                @error('stok')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="category_id">Kategori</label>
                <select name="category_id" id="category_id" class="form-control @error('category_id') is-invalid @enderror" required>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                @error('category_id')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Simpan Produk</button>
            <a href="{{ route('pages.products.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
    <!-- /.card-body -->
</div>
@endsection
