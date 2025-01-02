@extends('layouts.main')

@section('content')
<div class="container py-4">
    <h1 class="mb-4 text-center fw-bold text-uppercase text-primary">Dashboard</h1>

    <!-- Total Penjualan -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <h3 class="card-title text-primary fw-bold">Total Penjualan</h3>
                    <h2 class="fw-bold text-success display-4">Rp {{ number_format($totalSales, 2, ',', '.') }}</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistik Cepat -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <h5 class="card-title text-info fw-bold">Pendapatan Hari Ini</h5>
                    <h4 class="text-dark">Rp {{ number_format($todayRevenue, 2, ',', '.') }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <h5 class="card-title text-warning fw-bold">Stok Tersedia</h5>
                    <h4 class="text-dark">{{ $totalStok }} Produk</h4>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <h5 class="card-title text-success fw-bold">Total Transaksi Hari Ini</h5>
                    <h4 class="text-dark">{{ $totalTransactionsToday }} Transaksi</h4>
                </div>
            </div>
        </div>
    </div>

    <!-- Produk Terlaris -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card shadow-lg border-0">
                <div class="card-body text-center">
                    <h5 class="card-title text-primary fw-bold">Produk Terlaris</h5>
                    <h4 class="fw-bold text-dark">{{ $bestSellingProducts->first()->product->nama ?? 'N/A' }}</h4>
                    <p class="text-muted mb-1">
                        Merek: <span class="fw-bold">{{ $bestSellingProducts->first()->product->merek ?? 'No Brand' }}</span>
                    </p>
                    <p class="text-muted">
                        Total Terjual: <span class="text-success fw-bold">{{ $bestSellingProducts->first()->total_quantity ?? 0 }}</span>
                    </p>
                    <p class="text-muted">
                        Pendapatan: <span class="text-success fw-bold">Rp {{ number_format($bestSellingProducts->first()->total_sales ?? 0, 2, ',', '.') }}</span>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Transaksi Terbaru dan Grafik Penjualan -->
    <div class="row">
        <!-- Total Transaksi Terbaru -->
        <div class="col-md-4">
            <div class="card shadow-lg border-0">
                <div class="card-body text-center">
                    <h5 class="card-title text-primary fw-bold">Total Transaksi Terbaru</h5>
                    <h4 class="fw-bold text-dark">{{ $recentTransactions->count() }} Transaksi</h4>
                    <p class="text-muted">
                        Subtotal Terakhir:
                        <span class="text-success fw-bold">Rp {{ number_format($recentTransactions->last()->subtotal ?? 0, 2, ',', '.') }}</span>
                    </p>
                </div>
            </div>
        </div>

        <!-- Grafik Penjualan Bulanan -->
        <div class="col-md-8">
            <div class="card shadow-lg border-0">
                <div class="card-body">
                    <h5 class="card-title text-primary fw-bold">Grafik Penjualan Bulanan</h5>
                    <canvas id="monthlySalesChart" height="100"></canvas>
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
                labels: ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"],
                datasets: [{
                    label: "Penjualan Bulanan (Rp)",
                    data: [
                        {{ $monthlySales->get('01', 0) }},
                        {{ $monthlySales->get('02', 0) }},
                        {{ $monthlySales->get('03', 0) }},
                        {{ $monthlySales->get('04', 0) }},
                        {{ $monthlySales->get('05', 0) }},
                        {{ $monthlySales->get('06', 0) }},
                        {{ $monthlySales->get('07', 0) }},
                        {{ $monthlySales->get('08', 0) }},
                        {{ $monthlySales->get('09', 0) }},
                        {{ $monthlySales->get('10', 0) }},
                        {{ $monthlySales->get('11', 0) }},
                        {{ $monthlySales->get('12', 0) }}
                    ],
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
