<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\models\Produk;


class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Produk::factory()->create([
            'nama' => 'Coklat',
            'harga' => '5000',
            'jumlah' => 23,
            'kode_produk' => 'N09KD'
        ]);
        Produk::factory()->create([
            'nama' => 'Permen',
            'harga' => '500',
            'jumlah' => 100,
            'kode_produk' => 'NH34O'
        ]);
        Produk::factory()->create([
            'nama' => 'Astor',
            'harga' => '2000',
            'jumlah' => 50,
            'kode_produk' => 'NK09D'
        ]);
    }
}
