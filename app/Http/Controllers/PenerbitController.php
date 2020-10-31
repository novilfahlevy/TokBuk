<?php

namespace App\Http\Controllers;

use App\Buku;
use Illuminate\Http\Request;
use App\Penerbit;
use Exception;
use Illuminate\Support\Facades\DB;

class PenerbitController extends Controller
{
    public function __construct(Penerbit $penerbit)
    {
        $this->penerbit = $penerbit;
    }
    public function index()
    {
        $penerbit = $this->penerbit->get();
        return view('penerbit_admin.index', compact('penerbit'));
    }

    public function create()
    {
        return view('penerbit_admin.create');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required'
        ]);

       
        $insert = Penerbit::insert([
            'nama' => $request->nama,
            'alamat' => $request->alamat ?? '',
            'telepon' => $request->telepon ?? '',
            'email' => $request->email ?? ''
        ]);

        if($insert == true ){
            return redirect()->route('penerbit')->with(['message' => 'Berhasil Menambah Penerbit', 'type' => 'success']);
        } else {

            return redirect()->route('penerbit')->with(['message' => 'Gagal Menambah Penerbit', 'type' => 'danger']);
        }
    }

    // public function detail($id)
    // {
    //     $penerbit = Penerbit::where('id', $id)->first();
    //     return view('penerbit_admin.detail', compact('penerbit'));
    // }

    public function edit($id)
    {
        $penerbit = Penerbit::where('id', $id)->first();
        return view('penerbit_admin.edit', compact('penerbit'));
    }

    public function update(Request $request, $id)
    {
        $validate = $request->validate([
            'nama' => 'required'
        ]);

        $update = Penerbit::where('id', $id)->update([
            'nama' => $request->nama,
            'alamat' => $request->alamat ?? '',
            'telepon' => $request->telepon ?? '',
            'email' => $request->email ?? ''
        ]);

        if($update == true) {
            return redirect()->route('penerbit')->with(['message' => 'Berhasil Mengubah Penerbit', 'type' => 'success']);
        } else {
            return redirect()->route('penerbit')->with(['message' => 'Gagal Mengubah Penerbit', 'type' => 'danger']);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
		try {
			$penerbit = Penerbit::find($id);
			Buku::where('id_penerbit', $id)->update(['id_penerbit' => null]);
			$penerbit->delete();
			DB::commit();
			return redirect()->route('penerbit')->with(['message' => 'Berhasil Menghapus Penerbit', 'type' => 'success']);
		} catch ( Exception $e ) {
			DB::rollBack();
			return redirect()->route('penerbit')->with(['message' => 'gagal Menghapus Penerbit', 'type' => 'danger']);
		}
    }
}
