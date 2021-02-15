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
		return response()->json([
			'status' => Buku::where('isbn', $isbn)->count() ? 200 : 404
		]);
	}
}
