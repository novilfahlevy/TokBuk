<?php

namespace App\Http\Controllers\Api;

use App\Buku;
use App\Http\Controllers\Controller;

class TransaksiController extends Controller
{
  public function getDataBuku() 
	{
		return response()->json([
			'status' => 200,
			'buku' => Buku::where('jumlah', '>=', 1)->whereNotNull('harga')->get()
		]);
	}
}
