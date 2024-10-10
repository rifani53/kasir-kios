@extends('layouts.main')

@section('content')
<div class="container">
    <h2>Daftar Pengguna</h2>

    {{-- Pesan sukses setelah operasi berhasil --}}
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Tombol untuk menambah pengguna baru --}}
    <a href="{{ route('pages.penggunas.create') }}" class="btn btn-primary mb-3">Tambah Pengguna</a>

    {{-- Tabel daftar pengguna --}}
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($penggunas as $pengguna)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $pengguna->name }}</td>
                <td>{{ $pengguna->email }}</td>
                <td>
                    {{-- Tombol edit pengguna --}}
                    <a href="{{ route('pages.penggunas.edit', $pengguna->id) }}" class="btn btn-warning">Edit</a>

                    {{-- Tombol hapus pengguna --}}
                    <form action="{{ route('pages.penggunas.destroy', $pengguna->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
