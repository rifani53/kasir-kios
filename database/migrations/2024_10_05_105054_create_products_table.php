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
            $table->string('merek');
            $table->string('ukuran'); // Tambahkan kolom ukuran
            $table->decimal('harga', 10, 2); // Format harga dengan desimal
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('unit_id');
            $table->timestamps();

            // Definisi relasi foreign key
            $table->foreign('category_id')->references('id')->on('categories')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
            $table->foreign('unit_id')->references('id')->on('units')
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
