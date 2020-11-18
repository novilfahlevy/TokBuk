<?php

namespace App\Http\Controllers;

use App\Pengadaan;
use App\Retur;
use Illuminate\Http\Request;

class ReturController extends Controller
{
  public function index()
  {
    $returs = Retur::orderByDesc('tanggal')->get();
    return view('retur.index', compact('returs'));
  }

  public function create($id)
  {
    $pengadaan = Pengadaan::find($id);
    return view('retur.create', compact('pengadaan'));
  }

  public function store(Request $request, $id)
  {
    return response()->json($request->all());
  }

  public function getAllBuku($id)
  {
    $buku = Pengadaan::where('pengadaan.id', $id)
      ->join('detail_pengadaan as dp', 'dp.id_pengadaan', '=', 'pengadaan.id')
      ->join('buku', 'dp.id_buku', '=', 'buku.id')
      ->select(['buku.*', 'dp.jumlah as jumlah', 'dp.harga as harga', 'dp.id as id_pengadaan'])
      ->where('buku.jumlah', '>=', 1)
      ->get();
    
    return response()->json([
			'status' => 200,
			'buku' => $buku
		]);
  }
}
