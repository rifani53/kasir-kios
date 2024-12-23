@extends('layouts.main')

@section('content')
<div class="container">
    <h1>Keranjang</h1>

    @if (empty($cart))
        <div class="alert alert-info">Keranjang Anda kosong.</div>
        <a href="{{ route('pages.transactions.index') }}" class="btn btn-secondary">Kembali</a>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Produk</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Total</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cart as $id => $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item['name'] }}</td>
                        <td>Rp {{ number_format($item['price'], 0, ',', '.') }}</td>
                        <td>{{ $item['quantity'] }}</td>
                        <td>Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</td>
                        <td>
                            <form action="{{ route('cart.remove', $id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <th colspan="4" class="text-end">Total</th>
                    <th>Rp {{ number_format($totalPrice, 0, ',', '.') }}</th>
                    <th></th>
                </tr>
            </tbody>
        </table>

        <div class="text-end">
            <form action="{{ route('cart.complete') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn btn-success">Selesaikan Transaksi</button>
            </form>
            <form action="{{ route('cart.cancel') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn btn-warning">Batalkan Transaksi</button>
            </form>
        </div>
    @endif
</div>
@endsection
