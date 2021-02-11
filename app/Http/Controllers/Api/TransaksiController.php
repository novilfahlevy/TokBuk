<?php

namespace App\Http\Controllers\Api;

use App\Buku;
use App\Http\Controllers\Controller;

class TransaksiController extends Controller
{
  public function getDataBuku($isbn) 
	{
		$book = Buku::where('isbn', $isbn);
		return response()->json([
			'status' => $book->count() ? 200 : 404,
			'buku' => $book->first()
		]);
	}
}
