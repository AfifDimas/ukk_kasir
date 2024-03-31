<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\models\pelanggan;


class PelangganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pelanggan::Factory()->create([
            'nama_pelanggan' => 'Rudi',
            'alamat' => 'Pojok',
            'nomor_telepon' => '08123456789'
        ]);
    }
}
