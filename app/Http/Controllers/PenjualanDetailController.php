<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\PenjualanDetail;
use App\Models\Penjualan;
use App\Models\Produk;

use PDF;

class PenjualanDetailController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($id)
    {
        return view('detail_transaksi', compact('id'));
    }

    public function data($id)
    {

        $data = PenjualanDetail::where('id_transaksi', $id)->get();

        return datatables()
            ->of($data)
            ->addIndexColumn()
            ->addColumn('hargaRp', function ($data) {
                return 'Rp. ' . number_format($data->harga);
            })
            ->addColumn('totalRp', function ($data) {
                return 'Rp. ' . number_format($data->total);
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function update(Request $request)
    {
        $transaksi = Penjualan::findOrFail($request->id_transaksi);
        
        $transaksi->jumlah_barang = $request->total_item;
        $transaksi->total_harga = $request->total;
        $transaksi->update();

        $penjualan = new Penjualan();
        $penjualan->jumlah_barang = 0;
        $penjualan->total_harga = 0;
        $penjualan->save();

        return redirect()->route('penjualan')->withSuccess('Transaksi Berhasil Disimpan');

    }

    public function tambahProduk(Request $request)
    {

        $id_produk = $request->id;

        $produk = Produk::findOrFail($id_produk);
        $transaksi = Penjualan::orderBy('id', 'desc')->limit(1)->get();


        $penjualanDetail = new PenjualanDetail();
        $penjualanDetail->id_transaksi = $transaksi[0]->id;
        $penjualanDetail->nama_barang = $produk->nama;
        $penjualanDetail->id_barang = $id_produk;
        $penjualanDetail->kode_barang = $produk->kode_produk;
        $penjualanDetail->jumlah = 1;
        $penjualanDetail->harga = $produk->harga;
        $penjualanDetail->total = $produk->harga;
        $penjualanDetail->ditambahkan_tgl = date('y-m-d');
        $penjualanDetail->save();

        return response()->json('data Berhasil Disimpan', 200);
    }

    public function tambahJmlProduk(Request $request, $id)
    {

        $produkTransaksi = PenjualanDetail::find($id);
        $produkTransaksi->jumlah = $request->jumlah;
        $produkTransaksi->total = $produkTransaksi->harga * $request->jumlah;
        $produkTransaksi->update();
    }

    

    public function hapusData($id)
    {

        $produkDetail = PenjualanDetail::where('id', $id)->get();
        // dd($produkDetail->all());
        $produk = Produk::where('id', $produkDetail[0]->id_barang)->get();
        $produk[0]->jumlah += $produkDetail[0]->jumlah;

        $produk[0]->update();

        PenjualanDetail::destroy($id);
        return redirect()->route('penjualan');
    }

    public function loadForm( $diskon = 0, $subtotal = 0, $diterima = 0)
    {

        $kembali = $diterima - $subtotal;

        $data = [
            'diskon' => 0,
            'diterima' => number_format($diterima),
            'subtotal' => number_format($subtotal),
            'kembali' => number_format($kembali),
        ];

        return response()->json($data);
    }
}
