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
		$pembelian = DetailPembelianBuku::where(function($query) {
			$query->whereDate('detail_pembelian_buku.created_at', '>=', $this->mulai)->whereDate('detail_pembelian_buku.created_at', '<=', $this->sampai);
		});

		if ( $this->pemasok ) {
			$pembelian
				->join('pembelian_buku', 'pembelian_buku.id', '=', 'detail_pembelian_buku.id_pembelian')
				->where('pembelian_buku.id_pemasok', $this->pemasok);
		}

		$pembelian = $pembelian->get();

		return view('pembelian_buku.export', compact('pembelian'));
	}
}
