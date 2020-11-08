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
		$pembelian = DetailPembelianBuku::join('pembelian_buku', 'pembelian_buku.id', '=', 'detail_pembelian_buku.id_pembelian');

		if ( $this->mulai ) {
			$pembelian->whereDate('pembelian_buku.tanggal_terima', '>=', $this->mulai);
		}

		if ( $this->sampai ) {
			$pembelian->whereDate('pembelian_buku.tanggal_terima', '<=', $this->sampai);
		}

		if ( $this->distributor ) {
			$pembelian->where('pembelian_buku.id_distributor', $this->distributor);
		}

		$pembelian = $pembelian->get();

		return view('pembelian_buku.export', compact('pembelian'));
	}
}
