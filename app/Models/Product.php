<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Daftar kolom yang bisa diisi secara massal
    protected $fillable = [
        'nama', 'jenis', 'merek', 'ukuran', 'harga', 'stok', 'category_id', 'unit_id', 'sales_count', 'total_sold' // Tambahkan 'jenis' dan 'ukuran'
    ];

    // Mendefinisikan relasi dengan model Category
    public function category()
    {
        return $this->belongsTo(Category::class); // Pastikan ada model Category
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    // Relasi ke model Unit
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
    public function transactionDetails()
    {
    return $this->hasMany(TransactionDetail::class);
    }

}
