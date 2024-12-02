<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PenggunasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('penggunas')->insert([
            [
                'name' => 'Admin User',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('12345678'),
                'posisi' => 'admin',
            ],
            [
                'name' => 'Kasir User',
                'email' => 'kasir@example.com',
                'password' => Hash::make('password123'),
                'posisi' => 'kasir',
            ],
        ]);
    }
}
