@extends('layouts.main')

@section('content')
    <div class="container py-4">
        <h1 class="mb-4 text-center">Dashboard</h1>

        <!-- Total Penjualan -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card shadow-sm mb-4 border-0">
                    <div class="card-body text-center">
                        <h3 class="card-title text-primary">Total Penjualan</h3>
                        <h2 class="fw-bold text-success">Rp {{ number_format($totalSales, 2, ',', '.') }}</h2>
                    </div>
                </div>
            </div>
        </div>

        <!-- Persegi Berwarna dan Informasi Penting -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card shadow-sm text-center border-0 bg-info text-white">
                    <div class="card-body">
                        <h3 class="card-title">Pendapatan Hari Ini</h3>
                        <h4>Rp {{ number_format($todayRevenue, 2, ',', '.') }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm text-center border-0 bg-warning text-white">
                    <div class="card-body">
                        <h3 class="card-title">Stok Tersedia</h3>
                        <h4>{{ $totalStok }} Produk</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm text-center border-0 bg-success text-white">
                    <div class="card-body">
                        <h3 class="card-title">Total Transaksi Hari Ini</h3>
                        <h4>{{ $totalTransactionsToday }} Transaksi</h4>
                    </div>
                </div>
            </div>
        </div>

        <!-- Penjualan Bulanan dengan Grafik -->
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow-sm mb-4 border-0">
                    <div class="card-body">
                        <h3 class="card-title text-primary">Penjualan Bulanan</h3>
                        <canvas id="monthlySalesChart" height="100"></canvas>
                        <ul class="list-group mt-3">
                            @foreach ($monthlySales as $month => $total)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Bulan {{ $month }}
                                    <span class="badge bg-primary rounded-pill">
                                        Rp {{ number_format($total, 2, ',', '.') }}
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Transaksi Terbaru -->
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow-sm mb-4 border-0">
                    <div class="card-body">
                        <h3 class="card-title text-primary">Transaksi Terbaru</h3>
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Subtotal</th>
                                    <th>Jumlah</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($recentTransactions as $transaction)
                                    <tr>
                                        <td>{{ $transaction->id }}</td>
                                        <td>Rp {{ number_format($transaction->subtotal, 2, ',', '.') }}</td>
                                        <td>{{ $transaction->quantity }}</td>
                                        <td>{{ $transaction->created_at->format('d M Y') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Produk Terlaris -->
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow-sm mb-4 border-0">
                    <div class="card-body">
                        <h3 class="card-title text-primary">Produk Terlaris</h3>
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID Produk</th>
                                    <th>Total Terjual</th>
                                    <th>Total Penjualan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bestSellingProducts as $product)
                                    <tr>
                                        <td>{{ $product->product_id }}</td>
                                        <td>{{ $product->total_quantity }}</td>
                                        <td>Rp {{ number_format($product->total_sales, 2, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Grafik Penjualan Bulanan -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const ctx = document.getElementById("monthlySalesChart").getContext("2d");
            const monthlySalesChart = new Chart(ctx, {
                type: "bar",
                data: {
                    labels: {!! json_encode(array_keys($monthlySales->toArray())) !!}, // Bulan
                    datasets: [{
                        label: "Penjualan Bulanan (Rp)",
                        data: {!! json_encode(array_values($monthlySales->toArray())) !!}, // Total Penjualan
                        backgroundColor: "rgba(75, 192, 192, 0.6)",
                        borderColor: "rgba(75, 192, 192, 1)",
                        borderWidth: 1,
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: 'Grafik Penjualan Bulanan'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
@endsection
