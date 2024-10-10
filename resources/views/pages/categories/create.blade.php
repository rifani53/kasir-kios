@extends('layouts.main')

@section('header')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1>Tambah Kategori</h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('pages.categories.index') }}">Kategori</a></li>
            <li class="breadcrumb-item active">Tambah Kategori</li>
        </ol>
    </div>
</div>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Form Tambah Kategori</h3>
    </div>
    <div class="card-body">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('pages.categories.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Nama Kategori</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>

    </div>
    <!-- /.card-body -->
</div>
@endsection
