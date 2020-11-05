<?php

namespace App\Http\Controllers;

use App\Buku;
use App\PembelianBuku;
use App\Transaksi;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    protected $now;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
        $this->now = Carbon::now();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $pengguna = User::count();
				$judulBuku = Buku::count();
				$buku = (int) Buku::sum('jumlah');
        $transaksi = Transaksi::whereDate('created_at', $this->now->today()->format('Y-m-d'))->count();
        
        $penjualan = (object) $this->penjualan();
        $pembelian = (object) $this->pembelian();
        
        return view('home', compact('pengguna', 'judulBuku', 'buku', 'transaksi', 'penjualan', 'pembelian'));
    }

    public function penjualan()
	{
		$tahun = $this->now->year;
		$bulan = $this->now->month;

		$transaksi = Transaksi::whereYear('transaksi.created_at', $tahun)->whereMonth('transaksi.created_at', $bulan);

		$total = $transaksi->count();
		$pendapatan = $transaksi->sum('total_harga');
		$bukuTerjual = $transaksi->join('detail_transaksi as dt', 'dt.id_transaksi', '=', 'transaksi.id')
			->select(DB::raw('SUM(dt.jumlah) as buku_terjual'))
			->first();

		$waktuMasukan = Carbon::parse($tahun . '-' . $bulan);

		return [
			'totalTransaksi' => $total,
			'bukuTerjual' => (int) $bukuTerjual->buku_terjual,
			'pendapatan' => (int) $pendapatan,
			'tahun' => $tahun,
			'bulan' => $waktuMasukan->monthName
        ];
	}

	public function pembelian()
	{
		$tahun = $this->now->year;
		$bulan = $this->now->month;

		$pembelian = PembelianBuku::whereYear('pembelian_buku.tanggal', $tahun)->whereMonth('pembelian_buku.tanggal', $bulan);

		$totalPembelian = $pembelian->count();
		$pengeluaran = $pembelian->sum('total_harga');
		$bukuTerbeli = $pembelian->join('detail_pembelian_buku as dp', 'dp.id_pembelian', '=', 'pembelian_buku.id')
			->select(DB::raw('SUM(dp.jumlah) as buku_terbeli'))
			->first();

		$waktuMasukan = Carbon::parse($tahun . '-' . $bulan);

		return [
			'totalPembelian' => $totalPembelian,
			'bukuTerbeli' => (int) $bukuTerbeli->buku_terbeli,
			'pengeluaran' => (int) $pengeluaran,
			'tahun' => $tahun,
			'bulan' => $waktuMasukan->monthName
        ];
	}
}
