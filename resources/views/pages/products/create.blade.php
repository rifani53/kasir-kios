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

            <!-- Input Nama Produk -->
            <div class="form-group">
                <label for="nama">Nama Produk</label>
                <select name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror" required>
                    <option value="" disabled selected>Pilih Nama Produk</option>
                    @foreach ($masterProducts as $masterProduct)
                        <option value="{{ $masterProduct->nama_produk }}">{{ $masterProduct->nama_produk }}</option>
                    @endforeach
                </select>
                @error('nama')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <!-- Input Merek Produk -->
            <div class="form-group">
                <label for="merek">Merek Produk</label>
                <input type="text" name="merek" id="merek" class="form-control @error('merek') is-invalid @enderror" value="{{ old('merek', isset($product) ? $product->merek : '') }}" required>
                @error('merek')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            
            <!-- Input Ukuran Produk -->
            <div class="form-group">
                <label for="ukuran">Ukuran Produk</label>
                <input type="text" name="ukuran" id="ukuran" class="form-control @error('ukuran') is-invalid @enderror" required>
                @error('ukuran')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <!-- Input Harga -->
            <div class="form-group">
                <label for="harga">Harga</label>
                <input type="number" name="harga" id="harga" class="form-control @error('harga') is-invalid @enderror" required>
                @error('harga')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <!-- Input Stok -->
            <div class="form-group">
                <label for="stok">Stok</label>
                <input type="number" name="stok" id="stok" class="form-control @error('stok') is-invalid @enderror" required>
                @error('stok')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <!-- Input Kategori -->
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

            <!-- Input Satuan -->
            <div class="form-group">
                <label for="unit_id">Satuan</label>
                <select name="unit_id" id="unit_id" class="form-control @error('unit_id') is-invalid @enderror" required>
                    @foreach ($units as $unit)
                        <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                    @endforeach
                </select>
                @error('unit_id')
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
