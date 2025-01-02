@extends('layouts.main')

@section('header')
<div class="row mb-2 justify-content-center">
    <div class="col-md-8 text-center">
        <h1>Daftar Nama Produk</h1>
    </div>
</div>
@endsection

@section('content')
<div class="d-flex justify-content-center">
    <div class="card shadow-lg" style="width: 80%; border-radius: 10px;">
        <div class="card-header bg-primary text-white text-center" style="border-radius: 10px 10px 0 0;">

            <div class="card-tools">
                <a href="{{ route('pages.master_products.create') }}" class="btn btn-light btn-sm">+ Tambah Produk</a>
            </div>
        </div>

        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success text-center">
                    {{ session('success') }}
                </div>
            @endif

            <table class="table table-bordered table-striped text-center">
                <thead class="thead-dark">
                    <tr>
                        <th style="width: 10%;">No</th>
                        <th style="width: 60%;">Nama Produk</th>
                        <th style="width: 30%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($masterProducts as $index => $product)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $product->nama_produk }}</td>
                            <td>
                                <a href="{{ route('pages.master_products.edit', $product->id) }}"
                                   class="btn btn-warning btn-sm">
                                   <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('master_products.destroy', $product->id) }}"
                                      method="POST"
                                      style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                                        <i class="fas fa-trash-alt"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted">Belum ada produk.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-footer text-center bg-light">
            <p class="text-muted m-0">Daftar produk Anda akan tampil di sini</p>
        </div>
    </div>
</div>
@endsection
