@extends('layouts.main')

<<<<<<< Updated upstream
@section('content')
<div class="container">
    <h2>Edit Satuan</h2>

    <form action="{{ route('pages.units.update', $unit) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Nama Satuan</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $unit->name }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Update Satuan</button>
        <a href="{{ route('pages.units.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
=======
@section('header')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1>Edit Produk</h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('pages.products.index') }}">Produk</a></li>
            <li class="breadcrumb-item active">Edit Produk</li>
        </ol>
    </div>
</div>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Form Edit Produk</h3>
    </div>
    <div class="card-body">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('pages.products.update', $product->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="nama">Nama Produk</label>
                <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ $product->nama }}" required>
                @error('nama')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="harga">Harga</label>
                <input type="number" name="harga" id="harga" class="form-control @error('harga') is-invalid @enderror" value="{{ $product->harga }}" required>
                @error('harga')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="stok">Stok</label>
                <input type="number" name="stok" id="stok" class="form-control @error('stok') is-invalid @enderror" value="{{ $product->stok }}" required>
                @error('stok')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="category_id">Kategori</label>
                <select name="category_id" id="category_id" class="form-control @error('category_id') is-invalid @enderror" required>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
                @error('category_id')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <!-- Dropdown Satuan -->
            <div class="form-group">
                <label for="unit_id">Satuan</label>
                <select name="unit_id" id="unit_id" class="form-control @error('unit_id') is-invalid @enderror" required>
                    @foreach ($units as $unit)
                        <option value="{{ $unit->id }}" {{ $product->unit_id == $unit->id ? 'selected' : '' }}>{{ $unit->name }}</option>
                    @endforeach
                </select>
                @error('unit_id')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Update Produk</button>
            <a href="{{ route('pages.products.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
>>>>>>> Stashed changes
</div>
@endsection
