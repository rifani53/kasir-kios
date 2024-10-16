@extends('layouts.main')

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
        <form action="{{ route('pages.products.update', $product->id) }}" method="POST">
            @csrf
            @method('PUT') <!-- Method PUT untuk update -->
            
            <!-- Input Nama Produk -->
            <div class="form-group">
                <label for="nama">Nama Produk</label>
                <select name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror" required>
                    <option value="" disabled>Pilih Nama Produk</option>
                    @foreach ($masterProducts as $masterProduct)
                        <option value="{{ $masterProduct->nama_produk }}" {{ $product->nama == $masterProduct->nama_produk ? 'selected' : '' }}>
                            {{ $masterProduct->nama_produk }}
                        </option>
                    @endforeach
                </select>
                @error('nama')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>            
            
            <!-- Input Jenis Produk -->
            <div class="form-group">
                <label for="jenis">Jenis Produk</label>
                <input type="text" name="jenis" id="jenis" class="form-control @error('jenis') is-invalid @enderror" value="{{ old('jenis', $product->jenis) }}" required>
                @error('jenis')
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
                <input type="text" name="ukuran" id="ukuran" class="form-control @error('ukuran') is-invalid @enderror" value="{{ old('ukuran', $product->ukuran) }}" required>
                @error('ukuran')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <!-- Input Harga -->
            <div class="form-group">
                <label for="harga">Harga</label>
                <input type="number" name="harga" id="harga" class="form-control @error('harga') is-invalid @enderror" value="{{ old('harga', $product->harga) }}" required>
                @error('harga')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <!-- Input Stok -->
            <div class="form-group">
                <label for="stok">Stok</label>
                <input type="number" name="stok" id="stok" class="form-control @error('stok') is-invalid @enderror" value="{{ old('stok', $product->stok) }}" required>
                @error('stok')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <!-- Input Kategori -->
            <div class="form-group">
                <label for="category_id">Kategori</label>
                <select name="category_id" id="category_id" class="form-control @error('category_id') is-invalid @enderror" required>
                    <option value="" disabled>Pilih Kategori</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ $category->id == $product->category_id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
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
                    <option value="" disabled>Pilih Satuan</option>
                    @foreach ($units as $unit)
                        <option value="{{ $unit->id }}" {{ $unit->id == $product->unit_id ? 'selected' : '' }}>
                            {{ $unit->name }}
                        </option>
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
    <!-- /.card-body -->
</div>
@endsection
