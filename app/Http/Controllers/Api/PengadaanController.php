<?php

namespace App\Http\Controllers\Api;

use App\Buku;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PengadaanController extends Controller
{
  public function getDataBuku() 
	{
		return response()->json([
			'status' => 200,
			'buku' => Buku::get()
		]);
  }

	public function cekIsbn($isbn)
	{
		$buku = Buku::where('isbn', $isbn);
		$bukuSudahAda = $buku->count();

		return response()->json([
			'status' => $bukuSudahAda ? 200 : 404,
			'judul' => $bukuSudahAda ? $buku->first()->judul : null,
			'barcode' => $bukuSudahAda ? !!$buku->first()->barcode : false
		]);
	}
}
