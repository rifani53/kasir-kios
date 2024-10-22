@extends('layouts.main')

@section('header')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1>Tambah Master Product</h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('pages.master_products.index') }}">Kategori</a></li>
            <li class="breadcrumb-item active">Tambah Master Product</li>
        </ol>
    </div>
</div>
@endsection
@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Form Tambah Master Produk</h3>
    </div>
    <div class="card-body">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('master_products.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Nama Produk</label>
                <input type="text" class="form-control" id="nama_produk" name="nama_produk" required>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>

    </div>
    <!-- /.card-body -->
</div>
@endsection
