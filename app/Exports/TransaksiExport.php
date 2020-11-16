<?php

namespace App\Exports;

use App\DetailTransaksi;
use App\Transaksi;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;

class TransaksiExport implements FromView
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
		$transaksi = DetailTransaksi::join('transaksi as t', 't.id', '=', 'detail_transaksi.id_transaksi')
			->whereNull('t.deleted_at');

		if ( $this->mulai ) {
			$transaksi->whereDate('t.created_at', '>=', $this->mulai);
		}

		if ( $this->sampai ) {
			$transaksi->whereDate('t.created_at', '<=', $this->sampai);
		}

		$transaksi = $transaksi->get();

		return view('transaksi.export', [
			'transaksi' => $transaksi
		]);
	}
}
