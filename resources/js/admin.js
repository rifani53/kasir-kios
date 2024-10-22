// File: public/js/admin.js
document.addEventListener("DOMContentLoaded", function () {
    var ctx = document.getElementById('transactionChart').getContext('2d');
    var chart = new Chart(ctx, {
        type: 'line', // Pastikan type 'line' untuk menampilkan garis
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                label: 'Transaksi 2019',
                backgroundColor: 'rgba(60,141,188,0.1)', // Area di bawah garis
                borderColor: 'rgba(60,141,188,0.8)', // Warna garis
                data: [12, 19, 3, 5, 2, 3, 7, 8, 12, 14, 10, 15], // Data untuk ditampilkan
                fill: true, // Isi di bawah garis
            }]
        },
        options: {
            responsive: true, // Grafik responsive
            maintainAspectRatio: false,
            scales: {
                x: {
                    grid: {
                        display: true // Tampilkan garis grid vertikal
                    }
                },
                y: {
                    grid: {
                        display: true // Tampilkan garis grid horizontal
                    },
                    beginAtZero: true // Mulai dari angka 0
                }
            }
        }
    });
});
