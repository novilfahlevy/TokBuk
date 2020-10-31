<?php

namespace App\Exports;

use App\DetailTransaksi;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class TransaksiExport implements FromView
{
	/**
	* @return \Illuminate\Support\Collection
	*/
	public function view(): View
	{
		return view('transaksi.export', [
			'transaksi' => DetailTransaksi::all()
		]);
	}
}
