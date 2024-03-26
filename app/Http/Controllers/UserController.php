<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index() 
    {
        return view('petugas');
    }

    public function data()
    {
        $data = User::orderBy('id', 'desc')->get();

        return datatables()
            ->of($data)
            ->addIndexColumn()
            ->addColumn('nama', function ($data) {
                return $data->name . ' ' . $data->last_name; 
            })
            ->addColumn('status', function ($data) {
                if ($data->level == 1) {
                    return 'Admin'; 
                }
                if ($data->level == 2) {
                    return 'Petugas'; 
                }
            })
            ->addColumn('aksi', function ($data) {
                return '
                        <div class="btn-group">
                            <button class="btn btn-xs btn-info btn-flat" onclick="handleUpdate(' . $data->id . ')"><i class="fa fa-pencil"></i></button>
                            <a class="btn btn-xs btn-danger btn-flat" onclick="return confirm(`Yakin ingin menghapus data tersebut!!!`)" href="' . route('petugas.delete', $data->id ) . '"><i class="fa fa-trash"></i></a>
                        </div>
                        ';
            })
            ->rawColumns(['aksi'])
            ->make(true); 
    }

    public function create(Request $request)
    {
        $validate = $request->validate([  
                'name' => 'required', 'string', 'max:255',
                'last_name' => 'required', 'string', 'max:255',
                'email' => 'required', 'string', 'email', 'max:255', 'unique:users',
                'password' => 'required', 'string', 'min:8', 'confirmed',
                'level' => 'required',
        ]);

        User::create($validate);

        return redirect()->route('petugas')->withSuccess('Petugas Baru Berhasil Dibuat');
    }

    public function getUser($id)
    {
        $data = User::find($id);
        return response()->json($data);
    }

    public function update(Request $request)
    {
        $user = User::find($request->id);

        $user->name = $request->name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->level = $request->level_update;
        
        if($request->password != '') {
            $user->password = $request->password;
        }

        $user->update();

        return redirect()->route('petugas')->withSuccess('Berhasil mengupdate Data ');
    }

    public function delete($id) {
        User::destroy($id);

        return redirect()->route('petugas')->withSuccess('Berhasil Menghapus Data');
    }
}
