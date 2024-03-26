<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;

    protected $hidden = [
        'id', 'timestamps',
    ];

    public function penjualanDetail()
    {
        return $this->belongsTo(penjualanDetail::class);
    }

}
