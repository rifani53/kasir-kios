<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama', 'harga', 'stok', 'category_id' // Perhatikan penamaan di sini
    ];

    // Mendefinisikan relasi dengan model Category
    public function category()
    {
        return $this->belongsTo(Category::class); // Pastikan ada model Category
    }
    // Product.php
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

}
