<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransactionDetailSeeder extends Seeder
{
    public function run()
    {
        $transactionDetails = [
        
            ['transaction_id' => 3, 'pengguna_id' => 2, 'product_id' => 2, 'quantity' => 5, 'subtotal' => 40000.00], // Beras
            ['transaction_id' => 4, 'pengguna_id' => 2, 'product_id' => 2, 'quantity' => 14, 'subtotal' => 112000.00], // Beras
            ['transaction_id' => 5, 'pengguna_id' => 2, 'product_id' => 4, 'quantity' => 1, 'subtotal' => 5000.00], // Tepung Terigu
            ['transaction_id' => 6, 'pengguna_id' => 2, 'product_id' => 7, 'quantity' => 2, 'subtotal' => 20000.00], // Sarden Kaleng
            ['transaction_id' => 7, 'pengguna_id' => 2, 'product_id' => 8, 'quantity' => 2, 'subtotal' => 12000.00], // Kopi Bubuk
            ['transaction_id' => 8, 'pengguna_id' => 2, 'product_id' => 10, 'quantity' => 4, 'subtotal' => 14000.00], // Kecap Manis
            ['transaction_id' => 9, 'pengguna_id' => 2, 'product_id' => 11, 'quantity' => 5, 'subtotal' => 15000.00], // Mie Instan
        ];

        DB::table('transaction_details')->insert($transactionDetails);
    }
}
