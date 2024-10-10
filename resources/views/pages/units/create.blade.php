@extends('layouts.main')

@section('content')
<div class="container">
    <h2>Tambah Satuan</h2>

    <form action="{{ route('pages.units.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Nama Satuan</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan Satuan</button>
        <a href="{{ route('pages.units.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
