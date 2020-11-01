<?php

namespace App\Exports;

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
		$buku = PembelianBuku::where(function($query) {
			$query->whereDate('created_at', '>=', $this->mulai)->whereDate('created_at', '<=', $this->sampai);
		})
		->get();

		return view('buku_admin.logs-export', compact('buku'));
	}
}
