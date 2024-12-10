@extends('layouts.main')

@section('header')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1>Edit Satuan</h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadc   rumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('pages.units.index') }}">Satuan</a></li>
            <li class="breadcrumb-item active">Edit Satuan</li>
        </ol>
    </div>
</div>
@endsection

@section('content')
<div class="container">
    

    <form action="{{ route('pages.units.update', $unit) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Nama Satuan</label>
            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ $unit->name }}" required>
            @error('name')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Update Satuan</button>
        <a href="{{ route('pages.units.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
