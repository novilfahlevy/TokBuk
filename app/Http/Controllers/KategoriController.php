<?php

namespace App\Http\Controllers;

use App\Buku;
use Illuminate\Http\Request;
use App\Kategori;
use Exception;
use Illuminate\Support\Facades\DB;

class KategoriController extends Controller
{
    public function __construct(Kategori $kategori)
    {
        $this->Kategori = $kategori;
    }

    public function index()
    {
        $kategori = $this->Kategori->get();
        return view('kategori_admin.index', compact('kategori'));
    }
    
    public function store(Request $request)
    {
        $validate = $request->validate([
            'nama' => 'required'
        ]);

       
        $insert = Kategori::insert([
            'nama' => $request->nama
        ]);

        if($insert == true ){
            return redirect()->route('kategori')->with(['message' => 'Berhasil Menambah Kategori', 'type' => 'success']);
        } else {

            return redirect()->route('kategori')->with(['message' => 'Gagal Menambah Kategori', 'type' => 'error']);
        }
    }

    public function update(Request $request, $id)
    {
        $validate = $request->validate([
            'nama' => 'required'
        ]);

        $update = Kategori::where('id', $id)->update([
            'nama' => $request->nama
        ]);

        if($update == true) {
            return redirect()->route('kategori')->with(['message' => 'Berhasil Mengubah Kategori', 'type' => 'success']);
        } else {
            return redirect()->route('kategori')->with(['message' => 'Gagal Mengubah Kategori', 'type' => 'error']);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
		try {
			$kategori = Kategori::find($id);
			Buku::where('id_kategori', $id)->update(['id_kategori' => null]);
			$kategori->delete();
			DB::commit();
			return redirect()->route('kategori')->with('alert', [
				'type' => 'success',
				'message' => 'Berhasil menghapus buku'
			]);
		} catch ( Exception $e ) {
			DB::rollBack();
			return redirect()->route('kategori')->with('alert', [
				'type' => 'danger',
				'message' => 'Gagal menghapus buku'
			]);
		}
    }

}
