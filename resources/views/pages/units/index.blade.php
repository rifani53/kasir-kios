@extends('layouts.main')

@section('content')
<div class="container">
    <h2>Daftar Satuan</h2>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('pages.units.create') }}" class="btn btn-primary mb-3">Tambah Satuan</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Satuan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($units as $unit)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $unit->name }}</td>
                <td>
                    <a href="{{ route('pages.units.edit', $unit) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('pages.units.destroy', $unit) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus satuan ini?')">Hapus</button>
                    </form>
                </td>  
                
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
