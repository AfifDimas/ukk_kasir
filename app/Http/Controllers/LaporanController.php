<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use App\Models\Pelanggan;
use PDF;
use Yajra\DataTables\Facades\Datatables;


class LaporanController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('laporan');
    }

    public function data()
    {
        // $data = Penjualan::select('*');
        // return Datatables::of($data)
        //         ->addIndexColumn()
        //         ->adColumn('action', function($row){
        //             $actionBtn = '<a href="javascript:void(0)" class="edit btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm">Delete</a>';

        //             return $actionBtn;
        //         } )
        //         ->rawColumns(['action'])
        //         ->make('true');

        $data = Penjualan::orderBy('id', 'desc')->get();

        return datatables()
            ->of($data)
            ->addIndexColumn()
            ->addColumn('nama_pembeli', function($data) {
                $pelanggan = Pelanggan::where('id', $data->pelanggan_id)->get();
                return $pelanggan[0]->nama_pelanggan;
            })
            ->addColumn('harga_total', function($data) {
                return 'Rp. ' . number_format($data->total_harga);
            })
            ->addColumn('uang', function($data) {
                return 'Rp. ' . number_format($data->diterima);
            })
            ->addColumn('kembali', function($data) {
                return 'Rp. ' . number_format($data->kembalian);
            })
            ->addColumn('diskon%', function($data) {
                return number_format($data->diskon). '%';
            })
            ->addColumn('subTotal', function($data) {
                return 'Rp. ' . number_format($data->subtotal);
            })
            ->addColumn('tanggal', function($data) {
                return substr($data->created_at, 8, 2) . '-' . substr($data->created_at, 5, 2) . '-' . substr($data->created_at, 0, 4);
            })
            ->addColumn('aksi', function ($data) {
                return '
                        <div class="btn-group">
                            <a href="'.route('penjualanDetail', $data->id).'" class="btn btn-xs btn-info btn-flat"><i class="fa-solid fa-search"></i></a>
                        </div>
                        ';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function cetakPDF(Request $request) 
    {
        $tgl = $request->tanggal1;

        // mengambil dataID dari tabel barang
        $produks = Produk::get();
        $totalTransaksi = array();
        foreach ($produks as $produk) {
            $row = array();
            $jmlProduk = PenjualanDetail::where('id_barang', $produk->id)
                ->where('ditambahkan_tgl', $tgl)    
                ->SUM('jumlah');

            $row['nama_barang'] =  $produk->nama;
            $row['totalTerjual'] = $jmlProduk;
            $row['subtotal'] = $produk->harga * $jmlProduk; 

            $totalTransaksi[] = $row;
        }

        $tanggal = $tgl;

        $pdf = PDF::loadView('laporan.laporanPDF', compact('totalTransaksi', 'tanggal'));
    
        return $pdf->download('laporan-penjualan-' . $tanggal . '.pdf');
    }

    public function cetakNota()
    {
        $transaksi = Penjualan::orderBy('id', 'desc')->limit(1)->get();
        $data = PenjualanDetail::where('id_transaksi', $transaksi[0]->id)->get();

        return view('laporan.nota', compact('transaksi', 'data'));
    }
}


