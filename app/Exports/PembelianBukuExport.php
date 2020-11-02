<?php

namespace App\Exports;

use App\DetailPembelianBuku;
use App\PembelianBuku;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class PembelianBukuExport implements FromView
{
	private $mulai;
	private $sampai;

	public function __construct($mulai, $sampai)
	{
		$this->mulai = $mulai;
		$this->sampai = $sampai;
	}

	/**
	* @return \Illuminate\Support\Collection
	*/
	public function view(): View
	{
		$pembelian = DetailPembelianBuku::where(function($query) {
			$query->whereDate('created_at', '>=', $this->mulai)->whereDate('created_at', '<=', $this->sampai);
		})
		->get();

		return view('pembelian_buku.export', compact('pembelian'));
	}
}
