<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Transaction extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'status'];

    public function details()
    {
    return $this->hasMany(TransactionDetail::class, 'transaction_id'); // Atau nama model detail transaksi
    }
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id'); // 'product_id' adalah foreign key, 'id' adalah primary key di tabel products
    }
    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'pengguna_id'); // Jika transaksi juga menyimpan pengguna
    }

}
