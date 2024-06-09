<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Produk;

class ProdukController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('produk');
    }

    public function data()
    {
        $data = Produk::orderBy('id', 'desc')->get();

        return datatables()
            ->of($data)
            ->addIndexColumn()
            ->addColumn('stok', function($data) {
                return number_format($data->jumlah);
            })
            ->addColumn('hargaFormat', function($data) {
                return 'Rp. ' . number_format($data->harga);
            })
            ->addColumn('aksi', function ($data) {
                return '
                        <div class="btn-group">
                            <button onclick="handleEdit('. $data->id .')" class="btn btn-xs btn-info btn-flat"><i class="fa fa-pencil"></i></button>
                            <button onclick="handleHapus('. $data->id .')" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                        </div>
                        ';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function tambah(Request $request)
    {
        $validate = $request->validate([
            'nama' => 'required|min:3',
            'jumlah' => 'required|int|min:2',
            'harga' => 'required|int',
            'kode_produk' => 'required|unique:produks'
        ]);

        // $validate['kode_produk'] = 'P' .  

        Produk::create($validate);

        return redirect()->route('produk')->withSuccess('Berhasil Menambahkan produk :)');
    }

    public function update(Request $request)
    {
        $produk = Produk::find($request->id_produk);

        $produk->nama = $request->nama_edit;
        $produk->harga = $request->harga_edit;
        $produk->jumlah = $request->jumlah_edit;
        $produk->kode_produk = $request->kode_produk_edit;
        $produk->update();

        session()->flash('success', 'berhasil Mengubah Data Produk');
        return redirect()->route('produk');
    }

    public function delete($id) {
        Produk::destroy($id);
        return response()->json('Data Berhasil Dihapus');
    }

    public function selectProduk($id) 
    {
        $produk = Produk::findOrFail($id);

        return response()->json($produk);
    }
}
