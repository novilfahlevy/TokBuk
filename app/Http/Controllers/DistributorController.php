<?php

namespace App\Http\Controllers;

use App\Buku;
use Illuminate\Http\Request;
use App\Distributor;
use App\PembelianBuku;
use Exception;
use Illuminate\Support\Facades\DB;

class DistributorController extends Controller
{
    public function __construct(Distributor $distributor)
    {
        $this->Distributor = $distributor;
    }

    public function index()
    {
        $distributor = $this->Distributor->get();
        return view('distributor_admin.index', compact('distributor'));
    }

    public function create()
    {
        return view('distributor_admin.create');
    }
    
    public function store(Request $request)
    {
        $validate = $request->validate([
            'nama' => 'required',
            'alamat' => 'required',
            'email' => 'required',
            'telepon' => 'required'
        ]);

       
        $insert = Distributor::insert([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'email' => $request->email,
            'telepon' => $request->telepon
        ]);

        if($insert == true ){
            return redirect()->route('distributor')->with(['message' => 'Berhasil Menambah Distributor', 'type' => 'success']);
        } else {

            return redirect()->route('distributor')->with(['message' => 'Gagal Menambah Distributor', 'type' => 'danger']);
        }
    }

    public function edit($id)
    {
        $distributor = Distributor::where('id', $id)->first();
        return view('distributor_admin.edit', compact('distributor'));
    }

    public function update(Request $request, $id)
    {
        $validate = $request->validate([
            'nama' => 'required',
            'alamat' => 'required',
            'email' => 'required',
            'telepon' => 'required'
        ]);

        $update = Distributor::where('id', $id)->update([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'email' => $request->email,
            'telepon' => $request->telepon
        ]);

        if($update == true) {
            return redirect()->route('distributor')->with(['message' => 'Berhasil Mengedit Distributor', 'type' => 'success']);
        } else {
            return redirect()->route('distributor')->with(['message' => 'Gagal Mengedit Distributor', 'type' => 'danger']);
        }
    }

    public function destroy($id)
	{
		DB::beginTransaction();
		try {
			$distributor = Distributor::find($id);
			PembelianBuku::where('id_distributor', $id)->update(['id_distributor' => null]);
			$distributor->delete();
			DB::commit();
			return redirect()->route('distributor')->with(['message' => 'Berhasil Menghapus Distributor', 'type' => 'success']);
		} catch ( Exception $e ) {
			DB::rollBack();
			return redirect()->route('distributor')->with(['message' => 'Gagal Menghapus Distributor', 'type' => 'danger']);
		}
	}
}
