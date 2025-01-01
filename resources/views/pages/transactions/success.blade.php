@extends('layouts.main')

@section('content')
<div class="container mt-4">
    <h1>Transaksi Sukses</h1>

    <!-- Header -->
    <div class="header">
        <h1>Kios Anis</h1>
        <p>Alamat: Desa Bluru, Kec. Batu Ampar, Kabupaten Tanah Laut</p>
        <p><strong>Struk Transaksi</strong></p>
    </div>

    <p><strong>ID Transaksi:</strong> {{ $transaction->id }}</p>
    <p><strong>Tanggal:</strong> {{ $transaction->created_at->format('d-m-Y H:i') }}</p>
    <p><strong>Kasir:</strong> {{ $transaction->details->first()->pengguna->name ?? 'Tidak Diketahui' }}</p>
    <p><strong>Uang Pelanggan:</strong> Rp {{ number_format($customerMoney, 0, ',', '.') }}</p>
    <p><strong>Kembalian:</strong> Rp {{ number_format($change, 0, ',', '.') }}</p>



    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Nama Produk</th>
                <th>Kategori</th>
                <th>Harga Satuan</th>
                <th>Jumlah</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @php $totalHarga = 0; @endphp
            @foreach ($transaction->details as $detail)
                @php
                    $subtotal = $detail->product->harga * $detail->quantity;
                    $totalHarga += $subtotal;
                @endphp
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $detail->product->nama }}</td>
                    <td>{{ $detail->product->category->name }}</td>
                    <td>Rp {{ number_format($detail->product->harga, 0, ',', '.') }}</td>
                    <td>{{ $detail->quantity }}</td>
                    <td>Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Total Harga: Rp {{ number_format($totalHarga, 0, ',', '.') }}</h3>

    <p>Terima kasih telah berbelanja!</p>

    <!-- Tombol untuk Print dan Download PDF -->
    <!-- Tombol untuk Kirim ke WhatsApp -->
<div class="print-btn">
    <button onclick="window.print()" class="btn btn-primary">Print Struk</button>
    <a href="{{ route('transactions.downloadReceipt', $transaction->id) }}" class="btn btn-success">Download PDF</a>
    <a href="{{ route('pages.transactions.index') }}" class="btn btn-secondary">Kembali</a>
    <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#whatsappModal">Kirimkan Ke WhatsApp</button>
</div>

<!-- Modal untuk input nomor WhatsApp -->
<div class="modal fade" id="whatsappModal" tabindex="-1" aria-labelledby="whatsappModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('transactions.sendToWA', $transaction->id) }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="whatsappModalLabel">Kirim Struk ke WhatsApp</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="whatsapp_number" class="form-label">Nomor WhatsApp</label>
                        <input type="text" class="form-control" id="whatsapp_number" name="whatsapp_number" placeholder="Contoh: 628123456789" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-info">Kirim</button>
                </div>
            </div>
        </form>
    </div>
</div>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.getElementById('whatsappModal').addEventListener('shown.bs.modal', function () {
    console.log('Modal terbuka');
});
</script>

@endsection
