@extends('layouts.main')

@section('content')
<div class="container">
    <h1>Laporan Transaksi</h1>
    <form method="POST" action="{{ route('pages.laporan.export') }}">
        @csrf
        <input type="hidden" name="start_date" value="{{ $startDate }}">
        <input type="hidden" name="end_date" value="{{ $endDate }}">
        <button type="submit" class="btn btn-success">Export Laporan</button>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#dropboxModal">
            Lihat File Laporan di Dropbox
        </button>
    </form>

    <div class="modal fade" id="dropboxModal" tabindex="-1" aria-labelledby="dropboxModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="dropboxModalLabel">File Laporan di Dropbox</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <input type="text" id="searchInput" class="form-control" placeholder="Cari file..." onkeyup="filterTable()">
                    </div>
                    <table id="fileTable" style="width: 100%; border-collapse: collapse; margin-top: 20px;">
                        <thead>
                            <tr style="background-color: #f4f4f4; text-align: left;">
                                <th style="padding: 10px; border: 1px solid #ddd;">File Name</th>
                                <th style="padding: 10px; border: 1px solid #ddd;">Temporary Link</th>
                                <th style="padding: 10px; border: 1px solid #ddd;">Download</th>
                                <th style="padding: 10px; border: 1px solid #ddd;">Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($files as $file)
                            <tr style="border-bottom: 1px solid #ddd;">
                                <td style="padding: 10px; border: 1px solid #ddd;">{{ $file['name'] }}</td>
                                <td style="padding: 10px; border: 1px solid #ddd;">
                                    <button onclick="generateLink('{{ route('pages.dropbox.temporary-link', ['filePath' => $file['name']]) }}')"
                                        style="padding: 5px 10px; color: #fff; background-color: #007bff; border: none; border-radius: 5px; cursor: pointer;">
                                        Generate Link
                                    </button>
                                </td>
                                <td style="padding: 10px; border: 1px solid #ddd;">
                                    <a href="{{ route('pages.dropbox.download', ['fileName' => $file['name']]) }}"
                                        style="padding: 5px 10px; color: #fff; background-color: #007bff; text-decoration: none; border-radius: 5px;">
                                        Download
                                    </a>
                                </td>
                                <td style="padding: 10px; border: 1px solid #ddd;">
                                    <form action="{{ route('pages.dropbox.delete', ['fileName' => $file['name']]) }}" method="POST" style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus file ini?')"
                                            style="padding: 5px 10px; color: #fff; background-color: #dc3545; border: none; border-radius: 5px; cursor: pointer;">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div id="link-box" style="margin-top: 20px; display: none; padding: 15px; background-color: #f9f9f9; border: 1px solid #ddd; border-radius: 5px;">
                        <strong>Temporary Link:</strong>
                        <p id="temporary-link" style="margin: 10px 0; font-size: 14px; word-break: break-all;"></p>
                        <a href="#" id="open-link" target="_blank"
                           style="padding: 5px 10px; color: #fff; background-color: #28a745; text-decoration: none; border-radius: 5px;">
                            Open Link
                        </a>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Filter Laporan -->
    <form method="GET" action="{{ route('pages.laporan.index') }}" class="mb-4">
        <div class="row">
            <div class="col-md-4">
                <label for="start_date">Tanggal Mulai:</label>
                <input type="date" name="start_date" id="start_date" class="form-control" value="{{ $startDate }}">
            </div>
            <div class="col-md-4">
                <label for="end_date">Tanggal Selesai:</label>
                <input type="date" name="end_date" id="end_date" class="form-control" value="{{ $endDate }}">
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </div>
    </form>

    <!-- Total Pemasukan -->
    <div class="row mb-3">
        <div class="col-md-8">
            <h2>Data Transaksi</h2>
        </div>
        <div class="col-md-4 text-end">
            <h3>Total Pemasukan:</h3>
            <h3 class="text-success">Rp {{ number_format($totalIncome, 2, ',', '.') }}</h3>
        </div>
    </div>

    <!-- Data Transaksi -->
    @if($details->isEmpty())
        <p>Tidak ada transaksi pada periode ini.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>kasir</th>
                    <th>Tanggal</th>
                    <th>Produk</th>
                    <th>Jumlah</th>
                    <th>Harga Satuan</th>
                    <th>Total Harga</th>
                </tr>
            </thead>
            <tbody>
                @foreach($details as $detail)
                <tr>
                    <td>{{ $detail->pengguna->name ?? 'Tidak Diketahui' }}</td>
                    <td>{{ $detail->created_at->format('d-m-Y') }}</td>
                    <td>{{ $detail->product->nama ?? '-' }}</td>
                    <td>{{ $detail->quantity }}</td>
                    <td>Rp {{ number_format($detail->product->harga ?? 0, 2, ',', '.') }}</td>
                    <td>Rp {{ number_format($detail->quantity * ($detail->product->harga ?? 0), 2, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
<script>
    function generateLink(url) {
        fetch(url)
            .then(response => response.json())
            .then(data => {
                // Menampilkan kotak link
                const linkBox = document.getElementById('link-box');
                const temporaryLink = document.getElementById('temporary-link');
                const openLink = document.getElementById('open-link');

                // Mengisi data link
                temporaryLink.textContent = data.temporary_link;
                openLink.href = data.temporary_link;

                // Menampilkan kotak
                linkBox.style.display = 'block';
            })
            .catch(error => {
                alert('Gagal mendapatkan link. Silakan coba lagi.');
                console.error(error);
            });
        }

    function filterTable() {
        // Ambil nilai input pencarian
        const input = document.getElementById('searchInput');
        const filter = input.value.toLowerCase();
        const table = document.getElementById('fileTable');
        const rows = table.getElementsByTagName('tr');

        // Loop melalui baris tabel (mulai dari indeks 1 untuk melewati header)
        for (let i = 1; i < rows.length; i++) {
            const cells = rows[i].getElementsByTagName('td');
            let match = false;

            // Loop melalui sel-sel di baris
            for (let j = 0; j < cells.length; j++) {
                if (cells[j]) {
                    const textValue = cells[j].textContent || cells[j].innerText;
                    if (textValue.toLowerCase().indexOf(filter) > -1) {
                        match = true;
                        break;
                    }
                }
            }

            // Tampilkan atau sembunyikan baris berdasarkan pencarian
            rows[i].style.display = match ? '' : 'none';
        }
    }

</script>
@endsection
