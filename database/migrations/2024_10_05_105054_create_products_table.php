<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->decimal('harga', 10, 2); // Perbaikan tanda petik dan format
            $table->integer('stok');
            $table->unsignedBigInteger('unit_id');
            $table->unsignedBigInteger('category_id');
            $table->timestamps();

            $table->foreign('unit_id')->references('id')->on('units')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('categories') // Gunakan 'categories' sebagai nama tabel
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
