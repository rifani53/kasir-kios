@extends('layouts.main')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Form Pencarian -->
        <div class="col-md-8">
            <div class="mb-4">
                <input
                    type="text"
                    id="search-product"
                    class="form-control"
                    placeholder="Cari produk atau kategori..."
                    autocomplete="off">
                <div id="search-results" class="dropdown-menu show w-100" style="max-height: 300px; overflow-y: auto; display: none;">
                    <!-- Hasil pencarian akan ditampilkan di sini -->
                </div>
            </div>
            <!-- Tabel Daftar Produk -->
            <table class="table table-bordered" id="product-table" style="display: none;">
                <thead>
                    <tr>
                        <th>Nama Produk</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="product-list">
                    <tr>
                        <td colspan="5" class="text-center">Ketik untuk mencari produk.</td>
                    </tr>
                </tbody>
            </table>
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
                    @if (session('cart') && count(session('cart')) > 0)
                        <form action="{{ route('transactions.cart.complete') }}" method="POST" id="transaction-form">
                            @csrf
                            <div class="mb-3">
                                <label for="customer-money" class="form-label">Uang Pelanggan</label>
                                <input type="number" id="customer-money" name="customer_money" class="form-control" min="{{ $subtotal }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="change" class="form-label">Kembalian</label>
                                <input type="text" id="change" class="form-control" readonly>
                            </div>
                            <button type="submit" class="btn btn-success w-100">Selesaikan Transaksi</button>
                        </form>
                    @endif
                    <form action="{{ route('transactions.cart.cancel') }}" method="POST" class="mt-2">
                        @csrf
                        <button type="submit" class="btn btn-danger w-100">Batalkan Keranjang</button>
                    </form>
                    @php
                    $searchResults = session('search_results', []);
                    @endphp
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('search-product');
        const searchResults = document.getElementById('search-results');
        const productList = document.getElementById('product-list');
        const productTable = document.getElementById('product-table');
        const customerMoneyInput = document.getElementById('customer-money');
        const changeInput = document.getElementById('change');
        const subtotal = parseFloat({{ $subtotal }});
        const existingProducts = @json($searchResults);

        // Fungsi untuk menampilkan hasil pencarian
        const fetchProducts = (query) => {
    if (query.trim() === '') {
        resetProductTable();
        return;
    }

    fetch(`/search-product?query=${encodeURIComponent(query)}`)
        .then(response => response.json())
        .then(products => {
            if (products.length > 0) {
                localStorage.setItem('searchResults', JSON.stringify(products)); // Simpan hasil pencarian
                displayProducts(products);
            } else {
                resetProductTable();
            }
        })
        .catch(error => console.error('Error fetching products:', error));
};

    const displayProducts = (products) => {
    productTable.style.display = 'table';
    productList.innerHTML = products.map(product => `
        <tr>
            <td>${product.nama}</td>
            <td>${product.category.name}</td>
            <td>Rp ${parseFloat(product.harga).toLocaleString('id-ID')}</td>
            <td>${product.stok}</td>
            <td>
                ${product.stok > 0 ? `
                    <form action="${product.cart_add_url}" method="POST" class="d-flex">
                        @csrf
                        <input type="hidden" name="product_id" value="${product.id}">
                        <input type="number" name="quantity" value="1" min="1" max="${product.stok}" class="form-control me-2" style="width: 80px;">
                        <button type="submit" class="btn btn-success btn-sm">Tambah</button>
                    </form>` : `<span class="text-danger">Stok Habis</span>`}
            </td>
        </tr>
    `).join('');
};

        // Reset tabel produk
        const resetProductTable = () => {
            productTable.style.display = 'none';
            productList.innerHTML = `<tr><td colspan="5" class="text-center">Ketik untuk mencari produk.</td></tr>`;
        };

        // Event handler untuk input pencarian
        searchInput.addEventListener('input', (e) => fetchProducts(e.target.value));

        // Hitung kembalian otomatis
        if (customerMoneyInput && changeInput) {
            customerMoneyInput.addEventListener('input', () => {
                const customerMoney = parseFloat(customerMoneyInput.value);
                if (!isNaN(customerMoney) && customerMoney >= subtotal) {
                    const change = customerMoney - subtotal;
                    changeInput.value = `Rp ${change.toLocaleString('id-ID')}`;
                } else {
                    changeInput.value = '';
                }
            });
        }
        if (existingProducts.length > 0) {
        document.addEventListener('DOMContentLoaded', function () {
            const productTable = document.getElementById('product-table');
            const productList = document.getElementById('product-list');
            productTable.style.display = 'table';
            productList.innerHTML = existingProducts.map(product => `
                <tr>
                    <td>${product.name}</td>
                    <td>${product.category.name}</td>
                    <td>Rp ${parseFloat(product.price).toLocaleString('id-ID')}</td>
                    <td>${product.stock}</td>
                    <td>
                        <form action="${product.cart_add_url}" method="POST" class="d-flex">
                            @csrf
                            <input type="hidden" name="product_id" value="${product.id}">
                            <input type="number" name="quantity" value="1" min="1" max="${product.stock}" class="form-control me-2" style="width: 80px;">
                            <button type="submit" class="btn btn-success btn-sm">Tambah</button>
                        </form>
                    </td>
                </tr>
            `).join('');
              });
        }
    });
</script>
