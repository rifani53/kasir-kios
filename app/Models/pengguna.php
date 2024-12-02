<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class pengguna extends Authenticatable
{
    use HasFactory, Notifiable;

    // Jika kamu memiliki tabel dengan nama yang berbeda, kamu bisa mendefinisikannya di sini
    protected $table = 'penggunas';

    // Atribut yang dapat diisi massal
    protected $fillable = [
        'name',
        'email',
        'password',
        'posisi',
    ];

    // Atribut yang disembunyikan dari array dan JSON
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Mengatur timestamp jika diperlukan
    public $timestamps = true;

    // Jika ada relasi yang perlu ditambahkan, lakukan di sini
}
