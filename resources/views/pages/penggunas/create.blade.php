@extends('layouts.main')

@section('content')
<div class="container">
    <h2>Tambah Pengguna</h2>

    <form action="{{ route('pages.penggunas.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Nama</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="password">Kata Sandi</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="password_confirmation">Konfirmasi Kata Sandi</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan Pengguna</button>
        <a href="{{ route('pages.penggunas.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
