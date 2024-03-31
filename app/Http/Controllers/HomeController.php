<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\penjualan;
use App\Models\Produk;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $users = User::count();
        $hariIni = date('Y-m-d');
        $pendapatan = Penjualan::where('created_at', 'LIKE', '%'.$hariIni.'%')->SUM('subtotal');
        // dd($pendapatan);
        $produk = Produk::count();
        $transaksiHariIni = Penjualan::where('created_at', 'LIKE', '%'.$hariIni.'%')->count();
        // $tanggalAwal = date('Y-m-d', mktime(0, 0, 0, date('m'), 1, date('Y')));


        $widget = [
            'users' => $users,
            'pendapatan' => number_format($pendapatan),
            'produk' => $produk,
            'transaksi' => $transaksiHariIni,
        ];

        return view('home', compact('widget'));
    }
}
