@extends('layouts.main')

@section('header')
<div class="row mb-2 justify-content-center">
    <div class="col-md-8 text-center">
        <h1>Daftar Satuan</h1>
    </div>
</div>
@endsection

@section('content')
<div class="d-flex justify-content-center">
    <div class="card shadow-lg" style="width: 90%; border-radius: 10px;">
        <div class="card-header bg-primary text-white text-center" style="border-radius: 10px 10px 0 0;">

            <div class="card-tools">
                <a href="{{ route('pages.units.create') }}" class="btn btn-light btn-sm">+ Tambah Satuan</a>
            </div>
        </div>

        <div class="card-body">
            {{-- Pesan sukses --}}
            @if (session('success'))
                <div class="alert alert-success text-center">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Tabel daftar satuan --}}
            <table class="table table-bordered table-striped text-center">
                <thead class="thead-dark">
                    <tr>
                        <th style="width: 10%;">No</th>
                        <th style="width: 70%;">Nama Satuan</th>
                        <th style="width: 20%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($units as $index => $unit)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $unit->name }}</td>
                            <td>
                                <div class="d-flex justify-content-center" style="gap: 7px;">
                                    <a href="{{ route('pages.units.edit', $unit) }}"
                                       class="btn btn-warning btn-sm">
                                       <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('pages.units.destroy', $unit) }}"
                                          method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Yakin ingin menghapus satuan ini?')">
                                            <i class="fas fa-trash-alt"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="card-footer text-center bg-light">
            <p class="text-muted m-0">Daftar satuan Anda akan tampil di sini</p>
        </div>
    </div>
</div>
@endsection
