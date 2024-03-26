<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\models\Penjualan;
use App\models\PenjualanDetail;
use Reflection;

use PDF;

class PenjualanController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $transaksi = Penjualan::orderBy('id', 'desc')->limit(1)->get();
        // dd($transaksi);
        $id_transaksi = $transaksi[0]->id;
        $total_transaksi =PenjualanDetail::where('id_transaksi', $transaksi[0]->id)->SUM('total');
        $total_item =PenjualanDetail::where('id_transaksi', $transaksi[0]->id)->SUM('jumlah');

        return view('penjualan', compact('total_transaksi', 'id_transaksi', 'total_item'));
    }

    public function allDataProduk()
    {
        $data = Produk::orderBy('id', 'desc')->get();

        return datatables()
            ->of($data)
            ->addIndexColumn()
            ->addColumn('stok', function ($data) {
                return number_format($data->jumlah);
            })
            ->addColumn('aksi', function ($data) {
                return '
                        <div class="btn-group">
                            <button class="btn btn-xs btn-info btn-flat" onclick="tambahProduk('.$data->id.')"><i class="fa fa-plus"></i></button>
                            
                            
                        </div>
                        ';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function data()
    {
        $transaksi = Penjualan::orderBy('id', 'desc')->limit(1)->get();

        $detail = PenjualanDetail::where('id_transaksi', $transaksi[0]->id)->get();

        $data = array();
        $subtotal = 0;

        foreach ($detail as $item) {
            $row = array();
            $row['nama_barang'] = $item->nama_barang;
            $row['kode_barang'] = '<span class="label label-success">'. $item->kode_barang .'</span>';
            $row['jumlah_barang'] = '
                            <input type="number" class="form-control input-sm" id="quantity" data-id="'. $item->id .'" value="'.$item->jumlah.'">
                            ';
            $row['harga'] = 'Rp. ' . number_format($item->harga);
            $row['total'] = 'Rp. ' . number_format($item->total);
            $row['aksi'] = '<div class="btn-group">
                                <button class="btn btn-xs btn-info btn-flat" onclick="hapusData('.$item->id.')"><i class="fa fa-trash"></i></button>
                               
                            </div>';

            $data[] = $row;

            $subtotal += $item->harga * $item->jumlah; 
        }

        $data[] = [
            'nama_barang' => '',
            'kode_barang' => '<input type="hidden" id="subtotal" value="'.$subtotal.'">',
            'jumlah_barang' => '',
            'harga' => '',
            'total' => '',
            'aksi' => '',
        ];

        return datatables()
            ->of($data)
            ->addIndexColumn()
            ->rawColumns(['kode_barang', 'jumlah_barang', 'aksi'])
            ->make(true);


        // return datatables()
        //     ->of($data)
        //     ->addIndexColumn()
        //     ->addColumn('diskon', function () {
        //         return '0%';
        //     })
        //     ->addColumn('jumlah_barang', function ($data) {
        //         return '
        //                 <input type="number" class="form-control input-sm" id="quantity" data-id="'. $data->id .'" value="'.$data->jumlah.'">
        //                 ';
        //     })
        //     ->addColumn('aksi', function ($data) {
        //         return '
                            
        //                 ';
        //     })
        //     ->rawColumns(['aksi', 'jumlah_barang', 'harga_satuan'])
        //     ->make(true);
    }

    public function create()
    {
        $penjualan = new Penjualan();
        $penjualan->jumlah_barang = 0;
        $penjualan->total_harga = 0;
        $penjualan->diterima = 0;
        $penjualan->kembalian = 0;

        $penjualan->save();

        return redirect()->route('penjualan');
    }

    public function update(Request $request)
    {
        $transaksi = Penjualan::orderBy('id', 'desc')->limit(1)->get();
        $detail = PenjualanDetail::where('id_transaksi', $transaksi[0]->id)->get();
        $jumlahBarang = PenjualanDetail::where('id_transaksi', $transaksi[0]->id)->SUM('jumlah');


        $transaksi[0]->total_harga = $request->total;
        $transaksi[0]->jumlah_barang = $jumlahBarang;
        $transaksi[0]->diterima = $request->dbDiterima;
        $transaksi[0]->kembalian = $request->dbKembali;

        $transaksi[0]->update();
        
        return redirect()->route('penjualan')->withSuccess('Cetak Nota');


    }

    public function batal()
    {
        $transaksi = Penjualan::orderBy('id', 'desc')->limit(1)->get();

        PenjualanDetail::where('id_transaksi', $transaksi[0]->id)->delete();

        return redirect()->route('penjualan')->withSuccess('Transaksi Berhasil Dibatalkan');
        
    }
}
