@extends('layouts.main')

@section('content')
<div class="container">
    <h1>Halaman Transaksi</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <!-- Filter Kategori -->
    <form method="GET" action="{{ route('pages.transactions.index') }}" class="mb-4">
        <div class="form-group">
            <label for="category">Filter Kategori:</label>
            <select name="category" id="category" class="form-control" onchange="this.form.submit()">
                <option value="">Semua Kategori</option>
                @foreach($categories as $id => $name)
                    <option value="{{ $id }}" {{ $selectedCategoryId == $id ? 'selected' : '' }}>
                        {{ $name }}
                    </option>
                @endforeach
            </select>
        </div>
    </form>

    <!-- Daftar Produk dalam Tabel -->
    <h2>Produk</h2>
    <form method="POST" action="{{ route('transactions.store') }}">
        @csrf
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Pilih Produk</th>
                    <th>Nama Produk</th>
                    <th>Harga</th>
                    <th>Kategori</th>
                    <th>Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                <tr>
                    <td>
                        <input type="checkbox" name="product_ids[]" value="{{ $product->id }}" id="product_{{ $product->id }}">
                    </td>
                    <td>
                        <label for="product_{{ $product->id }}">{{ $product->nama }}</label>
                    </td>
                    <td>Rp {{ number_format($product->harga, 2) }}</td>
                    <td>{{ $product->category->name }}</td>
                    <td>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <button type="button" class="btn btn-outline-secondary btn-decrease" data-target="quantity_{{ $product->id }}">-</button>
                            </div>
                            <input type="number" name="quantities[{{ $product->id }}]" id="quantity_{{ $product->id }}" class="form-control quantity-input" value="1" min="1" required>
                            <div class="input-group-append">
                                <button type="button" class="btn btn-outline-secondary btn-increase" data-target="quantity_{{ $product->id }}">+</button>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <button type="submit" class="btn btn-primary mt-4">Tambah Transaksi</button>
    </form>

    <!-- Daftar Transaksi -->
    <h2>Transaksi Berlangsung</h2>
    @if($transactions->isEmpty())
        <p>Tidak ada transaksi berlangsung.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Jumlah</th>
                    <th>Total Harga</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transactions as $transaction)
                <tr>
                    <td>{{ $transaction->product->nama }}</td>
                    <td>{{ $transaction->quantity }}</td>
                    <td>Rp {{ number_format($transaction->total_price, 2) }}</td>
                    <td>{{ ucfirst($transaction->status) }}</td>
                    <td>
                        <form method="POST" action="{{ route('transactions.cancel', $transaction->id) }}" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin membatalkan transaksi ini?')">Batal</button>
                        </form>
                        <form method="POST" action="{{ route('transactions.complete', $transaction->id) }}" style="display:inline-block;">
                            @csrf
                            <button type="submit" class="btn btn-success btn-sm">Selesaikan</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <!-- Total Transaksi -->
    <h2>Total Transaksi</h2>
    <p>Total: Rp {{ number_format($totalAmount, 2) }}</p>
</div>

<!-- JavaScript untuk tombol plus dan minus -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.btn-decrease').forEach(function(button) {
            button.addEventListener('click', function() {
                const targetId = this.getAttribute('data-target');
                const input = document.getElementById(targetId);
                let value = parseInt(input.value);
                if (value > 1) {
                    input.value = value - 1;
                }
            });
        });

        document.querySelectorAll('.btn-increase').forEach(function(button) {
            button.addEventListener('click', function() {
                const targetId = this.getAttribute('data-target');
                const input = document.getElementById(targetId);
                let value = parseInt(input.value);
                input.value = value + 1;
            });
        });

        // Menonaktifkan input jumlah jika produk tidak dipilih
        document.querySelectorAll('input[type="checkbox"][name="product_ids[]"]').forEach(function(checkbox) {
            const productId = checkbox.value;
            const quantityInput = document.getElementById('quantity_' + productId);
            const btnIncrease = document.querySelector('.btn-increase[data-target="quantity_' + productId + '"]');
            const btnDecrease = document.querySelector('.btn-decrease[data-target="quantity_' + productId + '"]');

            function toggleQuantityInputs() {
                if (checkbox.checked) {
                    quantityInput.disabled = false;
                    btnIncrease.disabled = false;
                    btnDecrease.disabled = false;
                } else {
                    quantityInput.disabled = true;
                    btnIncrease.disabled = true;
                    btnDecrease.disabled = true;
                    quantityInput.value = 1;
                }
            }

            // Inisialisasi status awal
            toggleQuantityInputs();

            // Event listener untuk perubahan status checkbox
            checkbox.addEventListener('change', toggleQuantityInputs);
        });
    });
</script>
@endsection
