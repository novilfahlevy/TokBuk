<?php

namespace App\Http\Controllers;

use App\Buku;
use App\Lokasi;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LokasiController extends Controller
{
	public function index()
	{
		$lokasi = Lokasi::all();
		return view('lokasi.index', compact('lokasi'));
	}

	public function store(Request $request)
	{
		$lokasi = $request->lokasi;
		if ( Lokasi::create(['nama' => $lokasi]) ) {
			return redirect()->route('lokasi')->with([
				'type' => 'success',
				'message' => 'Berhasil Menambah Lokasi'
			]);
		}
		return redirect()->route('lokasi')->with([
			'type' => 'danger',
			'message' => 'Gagal Menambah Lokasi'
		]);
	}

	public function update(Request $request, $id)
	{
		$lokasi = Lokasi::find($id);
		if ( $lokasi->update(['nama' => $request->lokasi]) ) {
			return redirect()->route('lokasi')->with([
				'type' => 'success',
				'message' => 'Berhasil Mengedit Lokasi'
			]);
		}
		return redirect()->route('lokasi')->with([
			'type' => 'danger',
			'message' => 'Gagal Mengedit Lokasi'
		]);
	}

	public function destroy($id)
	{
		DB::beginTransaction();
		try {
			$lokasi = Lokasi::find($id);
			Buku::where('id_lokasi', $id)->update(['id_lokasi' => null]);
			$lokasi->delete();
			DB::commit();
			return redirect()->route('lokasi')->with([
				'type' => 'success',
				'message' => 'Berhasil Menghapus Lokasi'
			]);
		} catch ( Exception $e ) {
			DB::rollBack();
			return redirect()->route('lokasi')->with([
				'type' => 'danger',
				'message' => 'Gagal Menghapus Lokasi'
			]);
		}
	}
}
