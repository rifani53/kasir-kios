<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = ['status'];

    public function details()
{
    return $this->hasMany(TransactionDetail::class, 'transaction_id'); // Atau nama model detail transaksi
}

}
