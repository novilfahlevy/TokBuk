<?php

namespace App\Http\Controllers;

use App\Buku;
use Illuminate\Http\Request;
use App\Pemasok;
use App\PembelianBuku;
use Exception;
use Illuminate\Support\Facades\DB;

class PemasokController extends Controller
{
    public function __construct(Pemasok $pemasok)
    {
        $this->Pemasok = $pemasok;
    }

    public function index()
    {
        $pemasok = $this->Pemasok->get();
        return view('pemasok_admin.index', compact('pemasok'));
    }

    public function create()
    {
        return view('pemasok_admin.create');
    }
    
    public function store(Request $request)
    {
        $validate = $request->validate([
            'nama' => 'required',
            'alamat' => 'required',
            'email' => 'required',
            'telepon' => 'required'
        ]);

       
        $insert = Pemasok::insert([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'email' => $request->email,
            'telepon' => $request->telepon
        ]);

        if($insert == true ){
            return redirect()->route('pemasok')->with(['message' => 'Berhasil Menambah Pemasok', 'type' => 'success']);
        } else {

            return redirect()->route('pemasok')->with(['message' => 'Gagal Menambah Pemasok', 'type' => 'danger']);
        }
    }

    public function edit($id)
    {
        $pemasok = Pemasok::where('id', $id)->first();
        return view('pemasok_admin.edit', compact('pemasok'));
    }

    public function update(Request $request, $id)
    {
        $validate = $request->validate([
            'nama' => 'required',
            'alamat' => 'required',
            'email' => 'required',
            'telepon' => 'required'
        ]);

        $update = Pemasok::where('id', $id)->update([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'email' => $request->email,
            'telepon' => $request->telepon
        ]);

        if($update == true) {
            return redirect()->route('pemasok')->with(['message' => 'Berhasil Mengedit Pemasok', 'type' => 'success']);
        } else {
            return redirect()->route('pemasok')->with(['message' => 'Gagal Mengedit Pemasok', 'type' => 'danger']);
        }
    }

    public function destroy($id)
	{
		DB::beginTransaction();
		try {
			$pemasok = Pemasok::find($id);
			PembelianBuku::where('id_pemasok', $id)->update(['id_pemasok' => null]);
			$pemasok->delete();
			DB::commit();
			return redirect()->route('pemasok')->with(['message' => 'Berhasil Menghapus Pemasok', 'type' => 'success']);
		} catch ( Exception $e ) {
			DB::rollBack();
			return redirect()->route('pemasok')->with(['message' => 'Gagal Menghapus Pemasok', 'type' => 'danger']);
		}
	}
}
