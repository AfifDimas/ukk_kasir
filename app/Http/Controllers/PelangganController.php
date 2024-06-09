<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Pelanggan;

class PelangganController extends Controller
{
    public function create(Request $request)
    {

        // $pelanggan = [
        //     'nama_pelanggan' => $request->nama_pelanggan,
        //     'alamat' => $request->alamat,
        //     'nomor_telepon' => $request->nomor_telepon
        // ];
        $validate = $request->validate([
            'nama_pelanggan' => 'required',
            'alamat' => 'required',
            'nomor_telepon' => 'required|min:11|max:13'
        ]);
        Pelanggan::create($validate);

        return redirect()->route('penjualan.baru');
    }
}
