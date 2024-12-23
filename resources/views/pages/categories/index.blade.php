@extends('layouts.main')

@section('header')
<div class="row mb-2 justify-content-center">
    <div class="col-md-8 text-center">
        <h1>Daftar Kategori</h1>
    </div>
</div>
@endsection

@section('content')
<div class="d-flex justify-content-center">
    <div class="card shadow-lg" style="width: 80%; border-radius: 10px;">
        <div class="card-header bg-primary text-white text-center" style="border-radius: 10px 10px 0 0;">
            
            <div class="card-tools">
                <a href="{{ route('pages.categories.create') }}" class="btn btn-light btn-sm">+ Tambah Kategori</a>
            </div>
        </div>

        <div class="card-body">
            {{-- Pesan sukses setelah operasi berhasil --}}
            @if (session('success'))
                <div class="alert alert-success text-center">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Tabel daftar kategori --}}
            <table class="table table-striped table-hover text-center">
                <thead class="bg-secondary text-white">
                    <tr>
                        <th style="width: 5%;">No</th>
                        <th style="width: 65%;">Nama Kategori</th>
                        <th style="width: 30%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categories as $category)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $category->name }}</td>
                            <td>
                                {{-- Tombol edit kategori --}}
                                <a href="{{ route('pages.categories.edit', $category->id) }}" 
                                   class="btn btn-warning btn-sm">
                                   <i class="fas fa-edit"></i> Edit
                                </a>

                                {{-- Tombol hapus kategori --}}
                                <form action="{{ route('categories.destroy', $category->id) }}" 
                                      method="POST" 
                                      style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" 
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">
                                        <i class="fas fa-trash-alt"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted">Belum ada kategori.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-footer text-center bg-light">
            <p class="text-muted m-0">Daftar kategori Anda akan tampil di sini</p>
        </div>
    </div>
</div>
@endsection
