<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Pengadaan;
use Illuminate\Http\Request;

class ReturController extends Controller
{
  public function getDataBuku($id)
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
