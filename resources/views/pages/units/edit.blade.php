@extends('layouts.main')

@section('content')
<div class="container">
    <h2>Edit Satuan</h2>

    <form action="{{ route('pages.units.update', $unit) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Nama Satuan</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $unit->name }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Update Satuan</button>
        <a href="{{ route('pages.units.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
