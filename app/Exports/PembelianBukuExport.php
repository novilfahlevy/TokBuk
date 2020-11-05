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
	private $pemasok;

	public function __construct($mulai, $sampai, $pemasok)
	{
		$this->mulai = $mulai;
		$this->sampai = $sampai;
		$this->pemasok = $pemasok ?? null;
	}

	/**
	* @return \Illuminate\Support\Collection
	*/
	public function view(): View
	{
		$pembelian = DetailPembelianBuku::join('pembelian_buku', 'pembelian_buku.id', '=', 'detail_pembelian_buku.id_pembelian')
		->where(function($query) {
			$query->whereDate('pembelian_buku.tanggal', '>=', $this->mulai)->whereDate('pembelian_buku.tanggal', '<=', $this->sampai);
		});

		if ( $this->pemasok ) {
			$pembelian->where('pembelian_buku.id_pemasok', $this->pemasok);
		}

		$pembelian = $pembelian->get();

		return view('pembelian_buku.export', compact('pembelian'));
	}
}
