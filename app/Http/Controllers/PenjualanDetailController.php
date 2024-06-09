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
        $penjualanDetail->ditambahkan_tgl = date('Y-m-d');
        $penjualanDetail->save();

        return response()->json('data Berhasil Disimpan', 200);
    }

    public function tambahJmlProduk(Request $request, $id)
    {
        $produkTransaksi = PenjualanDetail::find($id);
        $produk = Produk::find($produkTransaksi->id_barang);
        if($request->jumlah > $produk->jumlah) {
        $produkTransaksi->jumlah = 0;
        $produkTransaksi->total = $produkTransaksi->harga * 0;
        $produkTransaksi->update();
            error;
        }
        $produkTransaksi->jumlah = $request->jumlah;
        $produkTransaksi->total = $produkTransaksi->harga * $request->jumlah;
        $produkTransaksi->update();
    }

    

    public function hapusData($id)
    {

        $produkDetail = PenjualanDetail::where('id', $id)->get();
        // dd($produkDetail->all());

        PenjualanDetail::destroy($id);
        return redirect()->route('penjualan');
    }

    public function loadForm( $diskon = 0, $total = 0, $diterima = 0)
    {

        $subtotal = $total - ($total * ($diskon / 100));

        $kembali = $diterima - $subtotal;

        $data = [
            'diskon' => $diskon,
            'diterima' => number_format($diterima),
            'total' => number_format($total),
            'subtotal' => number_format($subtotal),
            'kembali' => number_format($kembali),
            'db_diterima' => $diterima,
            'db_total' => $total,
            'db_subtotal' => $subtotal,
            'db_kembali' => $kembali,
        ];

        return response()->json($data);
    }
}
