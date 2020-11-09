<?php

namespace App\Http\Controllers;

use App\PembelianBuku;
use App\Transaksi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;
use App\Pengaturan;

class LaporanController extends Controller
{
	private $now;

	public function __construct()
	{
		$this->now = Carbon::now();
	}

	public function index()
	{
		$akhirBulan = $this->now->daysInMonth;
		return view('laporan.index', compact('akhirBulan'));
	}

	public function penjualan(Request $request)
	{
		$transaksi = Transaksi::whereDate('transaksi.created_at', '>=', $request->dari)->whereDate('transaksi.created_at', '<=', $request->sampai);

		$total = $transaksi->count();
		$pendapatan = $transaksi->sum('total_harga');
		$bukuTerjual = $transaksi->join('detail_transaksi as dt', 'dt.id_transaksi', '=', 'transaksi.id')
			->select(DB::raw('SUM(dt.jumlah) as buku_terjual'))
			->first();

		return response()->json([
			'status' => 200,
			'totalTransaksi' => $total,
			'bukuTerjual' => (int) $bukuTerjual->buku_terjual,
			'pendapatan' => (int) $pendapatan,
			'dari' => Carbon::parse($request->dari)->format('d-m-Y'),
			'sampai' => Carbon::parse($request->sampai)->format('d-m-Y')
		]);
	}

	public function pembelian(Request $request)
	{
		$pembelian = PembelianBuku::whereDate('pembelian_buku.tanggal', '>=', $request->dari)->whereDate('pembelian_buku.tanggal', '<=', $request->sampai);

		$totalPembelian = $pembelian->count();
		$pengeluaran = $pembelian->sum('total_harga');
		$bukuTerbeli = $pembelian->join('detail_pembelian_buku as dp', 'dp.id_pembelian', '=', 'pembelian_buku.id')
			->select(DB::raw('SUM(dp.jumlah) as buku_terbeli'))
			->first();

		return response()->json([
			'status' => 200,
			'totalPembelian' => $totalPembelian,
			'bukuTerbeli' => (int) $bukuTerbeli->buku_terbeli,
			'pengeluaran' => (int) $pengeluaran,
			'dari' => Carbon::parse($request->dari)->format('d-m-Y'),
			'sampai' => Carbon::parse($request->sampai)->format('d-m-Y')
		]);
	}

	public function pdfpenjualan($dari, $sampai)
	{
		$transaksi = Transaksi::whereDate('transaksi.created_at', '>=', $dari)->whereDate('transaksi.created_at', '<=', $sampai);

		$totalTransaksi = $transaksi->count();
		$pendapatan = $transaksi->sum('total_harga');
		$bukuTerjual = $transaksi->join('detail_transaksi as dt', 'dt.id_transaksi', '=', 'transaksi.id')
			->select(DB::raw('SUM(dt.jumlah) as buku_terjual'))
			->first();

		$dari = Carbon::parse($dari)->format('d-m-Y');
		$sampai = Carbon::parse($sampai)->format('d-m-Y');
		$pengaturan = Pengaturan::first();

		return PDF::loadView('transaksi.laporan', compact('totalTransaksi', 'pendapatan', 'bukuTerjual', 'pengaturan', 'dari', 'sampai'))->setPaper('a4', 'potrait')->download('laporan_transaksi_' . $dari . '_' . $sampai . '.pdf');
	}

	public function pdfpembelian($dari, $sampai) {
		$pembelian = PembelianBuku::whereDate('pembelian_buku.tanggal', '>=', $dari)->whereDate('pembelian_buku.tanggal', '<=', $sampai);

		$totalPembelian = $pembelian->count();
		$pengeluaran = $pembelian->sum('total_harga');
		$bukuTerbeli = $pembelian->join('detail_pembelian_buku as dp', 'dp.id_pembelian', '=', 'pembelian_buku.id')
			->select(DB::raw('SUM(dp.jumlah) as buku_terbeli'))
			->first();

		$dari = Carbon::parse($dari)->format('d-m-Y');
		$sampai = Carbon::parse($sampai)->format('d-m-Y');
		$pengaturan = Pengaturan::first();

		return PDF::loadView('pembelian_buku.laporan', compact('totalPembelian', 'pengeluaran', 'bukuTerbeli', 'pengaturan', 'dari', 'sampai'))->setPaper('a4', 'potrait')->download('laporan_pembelian_' . $dari . '_' . $sampai . '.pdf');
	}
}
