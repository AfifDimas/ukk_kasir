<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Pelanggan;

class PelangganController extends Controller
{
    public function create(Request $request)
    {
        $pelanggan = [
            'nama_pelanggan' => $request->nama_pelanggan,
            'alamat' => $request->alamat,
            'nomor_telepon' => $request->nomor_telepon
        ];
        Pelanggan::create($pelanggan);

        return redirect()->route('penjualan.baru');
    }
}
