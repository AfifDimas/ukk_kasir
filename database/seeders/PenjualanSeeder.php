<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\models\Penjualan;

class PenjualanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Penjualan::factory()->create([
            'jumlah_barang' => '0',
            'total_harga' => '0',
            'diskon' => '0',
            'subtotal' => '0',
            'diterima' => '0',
            'kembalian' => '0',
        ]);
        
    }
}
