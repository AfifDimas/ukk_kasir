<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenjualanDetail extends Model
{
    use HasFactory;

    protected $hidden = [
        'id', 'timestamps',
    ];

    public function penjualan()
    {
        return $this->hasOne(Penjualan::class);
    }

}
