<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $hidden = [
        'id', 'timestamps',
    ];

    protected $fillable = [
        'nama', 'jumlah', 'harga', 'kode_produk',
    ];
}