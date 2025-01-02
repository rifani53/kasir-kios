<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductMasterSeeder extends Seeder
{
    public function run()
    {
        $products = [
            ['nama_produk' => 'Gula Pasir'],
            ['nama_produk' => 'Beras'],
            ['nama_produk' => 'Minyak Goreng'],
            ['nama_produk' => 'Tepung Terigu'],
            ['nama_produk' => 'Sabun Cuci Piring'],
            ['nama_produk' => 'Pasta Gigi'],
            ['nama_produk' => 'Sarden Kaleng'],
            ['nama_produk' => 'Kopi Bubuk'],
            ['nama_produk' => 'Susu Kental Manis'],
            ['nama_produk' => 'Kecap Manis'],
            ['nama_produk' => 'Mie Instan'],
            ['nama_produk' => 'Sirup'],
            ['nama_produk' => 'Saus Sambal'],
            ['nama_produk' => 'Tepung Maizena'],
            ['nama_produk' => 'Margarin'],
            ['nama_produk' => 'Obat Nyamuk'],
            ['nama_produk' => 'Air Mineral'],
            ['nama_produk' => 'Telur Ayam'],
            ['nama_produk' => 'Garam'],
            ['nama_produk' => 'Detergen Bubuk'],
        ];

        DB::table('master_products')->insert($products);
    }
}
