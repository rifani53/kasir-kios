<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $products = [
            ['nama' => 'Gula Pasir', 'jenis' => 'Bahan Pokok', 'merek' => 'Brand A', 'ukuran' => '1 Kg', 'harga' => 10000.00, 'stok' => 100, 'category_id' => 1, 'unit_id' => 1],
            ['nama' => 'Beras', 'jenis' => 'Bahan Pokok', 'merek' => 'Brand B', 'ukuran' => '5 Kg', 'harga' => 8000.00, 'stok' => 50, 'category_id' => 1, 'unit_id' => 1],
            ['nama' => 'Minyak Goreng', 'jenis' => 'Bahan Pokok', 'merek' => 'Brand C', 'ukuran' => '2 L', 'harga' => 5000.00, 'stok' => 200, 'category_id' => 1, 'unit_id' => 1],
            ['nama' => 'Tepung Terigu', 'jenis' => 'Bahan Pokok', 'merek' => 'Brand D', 'ukuran' => '1 Kg', 'harga' => 5000.00, 'stok' => 150, 'category_id' => 1, 'unit_id' => 1],
            ['nama' => 'Sabun Cuci Piring', 'jenis' => 'Kebutuhan Rumah Tangga', 'merek' => 'Brand E', 'ukuran' => '250 ml', 'harga' => 1800.00, 'stok' => 300, 'category_id' => 1, 'unit_id' => 1],
            ['nama' => 'Pasta Gigi', 'jenis' => 'Kebutuhan Rumah Tangga', 'merek' => 'Brand F', 'ukuran' => '100 g', 'harga' => 9000.00, 'stok' => 80, 'category_id' => 1, 'unit_id' => 1],
            ['nama' => 'Sarden Kaleng', 'jenis' => 'Bahan Pokok', 'merek' => 'Brand G', 'ukuran' => '425 g', 'harga' => 10000.00, 'stok' => 60, 'category_id' => 1, 'unit_id' => 1],
            ['nama' => 'Kopi Bubuk', 'jenis' => 'Minuman', 'merek' => 'Brand H', 'ukuran' => '100 g', 'harga' => 6000.00, 'stok' => 120, 'category_id' => 1, 'unit_id' => 1],
            ['nama' => 'Susu Kental Manis', 'jenis' => 'Minuman', 'merek' => 'Brand I', 'ukuran' => '380 g', 'harga' => 9000.00, 'stok' => 90, 'category_id' => 1, 'unit_id' => 1],
            ['nama' => 'Kecap Manis', 'jenis' => 'Bahan Pokok', 'merek' => 'Brand J', 'ukuran' => '300 ml', 'harga' => 3500.00, 'stok' => 110, 'category_id' => 1, 'unit_id' => 1],
            ['nama' => 'Mie Instan', 'jenis' => 'Bahan Pokok', 'merek' => 'Brand K', 'ukuran' => '75 g', 'harga' => 3000.00, 'stok' => 500, 'category_id' => 1, 'unit_id' => 1],
            ['nama' => 'Sirup', 'jenis' => 'Minuman', 'merek' => 'Brand L', 'ukuran' => '700 ml', 'harga' => 3500.00, 'stok' => 70, 'category_id' => 1, 'unit_id' => 1],
            ['nama' => 'Saus Sambal', 'jenis' => 'Bumbu', 'merek' => 'Brand M', 'ukuran' => '200 ml', 'harga' => 5000.00, 'stok' => 90, 'category_id' => 1, 'unit_id' => 1],
            ['nama' => 'Tepung Maizena', 'jenis' => 'Bahan Pokok', 'merek' => 'Brand N', 'ukuran' => '500 g', 'harga' => 8000.00, 'stok' => 130, 'category_id' => 1, 'unit_id' => 1],
            ['nama' => 'Margarin', 'jenis' => 'Bahan Pokok', 'merek' => 'Brand O', 'ukuran' => '200 g', 'harga' => 4000.00, 'stok' => 100, 'category_id' => 1, 'unit_id' => 1],
            ['nama' => 'Obat Nyamuk', 'jenis' => 'Kebutuhan Rumah Tangga', 'merek' => 'Brand P', 'ukuran' => '1 Pack', 'harga' => 5000.00, 'stok' => 50, 'category_id' => 1, 'unit_id' => 1],
            ['nama' => 'Air Mineral', 'jenis' => 'Minuman', 'merek' => 'Brand Q', 'ukuran' => '600 ml', 'harga' => 5000.00, 'stok' => 400, 'category_id' => 1, 'unit_id' => 1],
            ['nama' => 'Telur Ayam', 'jenis' => 'Bahan Pokok', 'merek' => 'Brand R', 'ukuran' => '1 Kg', 'harga' => 14000.00, 'stok' => 200, 'category_id' => 1, 'unit_id' => 1],
            ['nama' => 'Garam', 'jenis' => 'Bahan Pokok', 'merek' => 'Brand S', 'ukuran' => '500 g', 'harga' => 5000.00, 'stok' => 300, 'category_id' => 1, 'unit_id' => 1],
            ['nama' => 'Detergen Bubuk', 'jenis' => 'Kebutuhan Rumah Tangga', 'merek' => 'Brand T', 'ukuran' => '1 Kg', 'harga' => 7000.00, 'stok' => 150, 'category_id' => 1, 'unit_id' => 1],
        ];

        DB::table('products')->insert($products);
    }
}
