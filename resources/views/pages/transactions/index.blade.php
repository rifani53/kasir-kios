@extends('layouts.main')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Konten Utama -->
        <div class="col-md-8">
            <!-- Form Filter dan Pencarian -->
            <form method="GET" action="{{ route('pages.transactions.index') }}" class="mb-4">
                <div class="row">
                    <div class="col-md-6">
                        <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Cari produk atau kategori...">
                    </div>

                    <div class="col-md-4">
                        <select name="category" class="form-control">
                            <option value="">Semua Kategori</option>
                            @foreach ($categories as $id => $name)
                                <option value="{{ $id }}" {{ $selectedCategoryId == $id ? 'selected' : '' }}>
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">Filter</button>
                    </div>
                </div>
            </form>

            <!-- Tabel Daftar Produk -->
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nama Produk</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products->take(7) as $product)
                        <tr>
                            <td>{{ $product->nama }}</td>
                            <td>{{ $product->category->name }}</td>
                            <td>Rp {{ number_format($product->harga, 0, ',', '.') }}</td>
                            <td>{{ $product->stok }}</td>
                            <td>
                                @if ($product->stok > 0)
                                    <form action="{{ route('transactions.cart.add') }}" method="POST" class="d-flex">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <input type="number" name="quantity" value="1" min="1" max="{{ $product->stok }}" class="form-control me-2" style="width: 80px;">
                                        <button type="submit" class="btn btn-success btn-sm">Tambah</button>
                                    </form>
                                @else
                                    <span class="text-danger">Stok Habis</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada produk ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            @if ($products->count() > 7)
                <div class="text-center mt-3">
                    <a href="{{ route('pages.transactions.index', array_merge(request()->all(), ['show_all' => true])) }}" class="btn btn-secondary">Tampilkan Lebih Banyak</a>
                </div>
            @endif
        </div>

        <!-- Keranjang di Samping Kanan -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5>Keranjang</h5>
                </div>
                <div class="card-body">
                    @if (session('cart') && count(session('cart')) > 0)
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Produk</th>
                                    <th>Jumlah</th>
                                    <th>Harga</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach (session('cart') as $id => $item)
                                    <tr>
                                        <td>{{ $item['name'] }}</td>
                                        <td>{{ $item['quantity'] }}</td>
                                        <td>Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</td>
                                        <td>
                                            <form action="{{ route('transactions.cart.remove', $id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <hr>
                        <h5>Total Harga: Rp {{ number_format($subtotal, 0, ',', '.') }}</h5>
                    @else
                        <p class="text-center">Keranjang kosong</p>
                    @endif
                </div>
                <div class="card-footer">
                    <form action="{{ route('transactions.cart.complete') }}" method="POST" class="mb-2">
                        @csrf
                        <button type="submit" class="btn btn-success w-100">Selesaikan Transaksi</button>
                    </form>
                    <form action="{{ route('transactions.cart.cancel') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger w-100">Batalkan Keranjang</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
