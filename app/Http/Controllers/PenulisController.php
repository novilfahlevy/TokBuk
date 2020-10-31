<?php

namespace App\Http\Controllers;

use App\Buku;
use Illuminate\Http\Request;
use App\Penulis;
use Exception;
use Illuminate\Support\Facades\DB;

class PenulisController extends Controller
{
    public function __construct(Penulis $penulis)
    {
        $this->penulis = $penulis;
    }
    public function index()
    {
        $penulis = $this->penulis->get();
        return view('penulis_admin.index', compact('penulis'));
    }
    
    public function store(Request $request)
    {
        $validate = $request->validate([
            'nama' => 'required'
        ]);

       
        $insert = Penulis::insert([
            'nama' => $request->nama
        ]);

        if($insert == true ){
            return redirect()->route('penulis')->with(['message' => 'Berhasil Menambah Penulis', 'type' => 'success']);
        } else {

            return redirect()->route('penulis')->with(['message' => 'Gagal Menambah Penulis', 'type' => 'danger']);
        }
    }

    
    public function update(Request $request, $id)
    {
        $validate = $request->validate([
            'nama' => 'required'
        ]);

        $update = Penulis::where('id', $id)->update([
            'nama' => $request->nama
        ]);

        if($update == true) {
            return redirect()->route('penulis')->with(['message' => 'Berhasil Mengubah Nama Penulis', 'type' => 'success']);
        } else {
            return redirect()->route('penulis')->with(['message' => 'Gagal Mengubah Nama Penulis', 'type' => 'danger']);
        }
    }
    
    public function destroy($id)
    {
        DB::beginTransaction();
		try {
			$penulis = Penulis::find($id);
			Buku::where('id_penulis', $id)->update(['id_penulis' => null]);
			$penulis->delete();
			DB::commit();
			return redirect()->route('penulis')->with([
				'type' => 'success',
				'message' => 'Berhasil menghapus penulis'
			]);
		} catch ( Exception $e ) {
			DB::rollBack();
			return redirect()->route('penulis')->with([
				'type' => 'danger',
				'message' => 'Gagal menghapus Penulis'
			]);
		}
    }
}
