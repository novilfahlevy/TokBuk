<?php

namespace App\Http\Controllers;

use App\Pemasok;
use App\PembelianBuku;
use Illuminate\Http\Request;

class PembelianBukuController extends Controller
{
	public function index()
	{
		$pembelian = PembelianBuku::orderBy('created_at', 'DESC')->get();
		return view('pembelian_buku.index', compact('pembelian'));
	}

	public function create(Request $request)
	{
		$pemasok = Pemasok::all();

		return view('pembelian_buku.create', compact('pemasok'));
	}

	public function store(Request $request)
	{
		dd($request->all());
	}
}
