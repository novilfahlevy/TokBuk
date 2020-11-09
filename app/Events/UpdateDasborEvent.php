<?php

namespace App\Events;

use App\Buku;
use App\PembelianBuku;
use App\Transaksi;
use Carbon\Carbon;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class UpdateDasborEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $jumlahTransaksi;
    public $jumlahBuku;
    public $jumlahJudulBuku;
    public $transaksi;
    public $pembelian;
    public $now;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->now = Carbon::now();

        $this->jumlahTransaksi = Transaksi::count();
        $this->jumlahBuku = Buku::sum('jumlah');
        $this->jumlahJudulBuku = Buku::count();
        $this->transaksi = $this->penjualan();
        $this->pembelian = $this->pembelian();
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return ['dasbor'];
    }

    public function broadcastAs()
    {
        return 'dasbor.update';
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
