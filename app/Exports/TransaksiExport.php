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
		$transaksi = Transaksi::join('detail_transaksi as dt', 'transaksi.id', '=', 'dt.id_transaksi')
			->where(function($query) {
				$query->whereDate('transaksi.created_at', '>=', $this->mulai)->whereDate('transaksi.created_at', '<=', $this->sampai);
			})
			->select([
				'transaksi.created_at',
				DB::raw('SUM(dt.jumlah) AS jumlah_buku'),
				'transaksi.total_harga',
				'transaksi.uang_pembeli',
				'transaksi.id'
			])
			->groupBy([
				'transaksi.created_at',
				'transaksi.total_harga', 
				'transaksi.uang_pembeli',
				'transaksi.id'
			])
			->get();

		return view('transaksi.export', [
			'transaksi' => $transaksi
		]);
	}
}
