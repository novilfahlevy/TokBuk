<?php

namespace App\Exports;

use App\DetailPengadaan;
use App\Pengadaan;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class PengadaanExport implements FromView
{
	private $mulai;
	private $sampai;
	private $distributor;

	public function __construct($mulai, $sampai, $distributor)
	{
		$this->mulai = $mulai;
		$this->sampai = $sampai;
		$this->distributor = $distributor ?? null;
	}

	/**
	* @return \Illuminate\Support\Collection
	*/
	public function view(): View
	{
		$pembelian = DetailPengadaan::join('pengadaan', 'pengadaan.id', '=', 'detail_pengadaan.id_pengadaan');

		if ( $this->mulai ) {
			$pembelian->whereDate('pengadaan.tanggal', '>=', $this->mulai);
		}

		if ( $this->sampai ) {
			$pembelian->whereDate('pengadaan.tanggal', '<=', $this->sampai);
		}

		if ( $this->distributor ) {
			$pembelian->where('pengadaan.id_distributor', $this->distributor);
		}

		$pembelian = $pembelian->get();

		return view('pengadaan.export', compact('pembelian'));
	}
}
