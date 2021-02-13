<?php

namespace App\Http\Controllers\Api;

use App\Buku;
use App\Http\Controllers\Controller;

class TransaksiController extends Controller
{
  public function getBukuByBarcode($barcodeOrISBN) 
	{
		// Pencarian buku selain menggunakan barcode bisa menggunakan ISBN
		$book = Buku::where('isbn', $barcodeOrISBN)
			->orWhere('barcode_1d', $barcodeOrISBN)
			->orWhere('barcode_2d', $barcodeOrISBN);

		return response()->json([
			'status' => $book->count() ? 200 : 404,
			'buku' => $book->first()
		]);
	}

  public function getBukuByKeyword($keyword) 
	{
		$book = Buku::select([
			'buku.id as id',
			'buku.isbn as isbn',
			'buku.judul as judul',
			'penulis.nama as penulis',
			'penerbit.nama as penerbit',
			'buku.jumlah as jumlah',
			'buku.sampul as sampul'
		])
			->join('penulis', 'buku.id_penulis', '=', 'penulis.id')
			->join('penerbit', 'buku.id_penerbit', '=', 'penerbit.id')
			->where('isbn', $keyword)
			->orWhere('judul', 'LIKE', "%$keyword%")
			->orWhere('penulis.nama', 'LIKE', "%$keyword%")
			->orWhere('penerbit.nama', 'LIKE', "%$keyword%")
			->where('jumlah', '>=', 1);

		return response()->json([
			'status' => $book->count() ? 200 : 404,
			'buku' => $book->get()
		]);
	}
}
