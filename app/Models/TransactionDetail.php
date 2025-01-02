<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    protected $fillable = ['transaction_id', 'pengguna_id', 'product_id', 'quantity', 'subtotal', 'created_at', 'updated_at'];

    // Relasi dengan Transaction
    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id');
    }

    // Relasi dengan Product
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'pengguna_id');
    }
}
