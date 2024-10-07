@extends('layouts.main')

@section('content')
<div class="container">
    <h2>Daftar Kategori</h2>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('pages.categories.create') }}" class="btn btn-primary mb-3">Tambah Kategori</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Kategori</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $category)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $category->name }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
