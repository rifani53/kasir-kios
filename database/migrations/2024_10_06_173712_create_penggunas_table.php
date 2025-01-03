<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenggunasTable extends Migration
{
    public function up()
    {
        Schema::create('penggunas', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama pengguna
            $table->string('email')->unique(); // Email pengguna
            $table->string('password'); // Kata sandi
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('penggunas');
    }
}
