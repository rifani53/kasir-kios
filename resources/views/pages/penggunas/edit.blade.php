@extends('layouts.main')

@section('content')
<div class="container">
    <h2>Edit Pengguna</h2>

    <form action="{{ route('pages.penggunas.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Nama</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $user->name }}" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ $user->email }}" required>
        </div>
        <div class="form-group">
            <label for="password">Kata Sandi (biarkan kosong jika tidak ingin mengubah)</label>
            <input type="password" name="password" id="password" class="form-control">
        </div>
        <div class="form-group">
            <label for="password_confirmation">Konfirmasi Kata Sandi</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Update Pengguna</button>
        <a href="{{ route('pages.penggunas.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
