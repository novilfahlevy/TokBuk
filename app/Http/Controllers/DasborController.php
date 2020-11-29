<?php

namespace App\Http\Controllers;

use App\Buku;
use App\Pengaturan;
use App\RiwayatAktivitas;
use App\Transaksi;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DasborController extends Controller
{
  private $now;
  private $transaksiHariIni;
  private $pendapatanHariIni;
  private $batasanStok;
  private $jumlahJudulBuku;
  private $jumlahBuku;
  private $aktivitasTerakhir;

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    // $this->middleware('auth');
    $this->now = Carbon::now();
    $this->transaksiHariIni = Transaksi::whereDate('created_at', $this->now->today()->format('Y-m-d'));
    $this->pendapatanHariIni = $this->transaksiHariIni->sum('total_harga');
    $this->batasanStok = Pengaturan::first()->limit_stok;
    $this->jumlahJudulBuku = Buku::count();
    $this->jumlahBuku = Buku::sum('jumlah');
    $this->aktivitasTerakhir = RiwayatAktivitas::latest()->first();
  }

  private function getChartBestSeller(): array
  {
    $transaksiBulanIni = Transaksi::whereMonth('transaksi.created_at', $this->now->month);

    $bestSeller = $transaksiBulanIni->join('detail_transaksi as dt', 'dt.id_transaksi', '=', 'transaksi.id')
      ->join('buku', 'buku.id', '=', 'dt.id_buku')
      ->select(['buku.isbn', 'buku.judul', DB::raw('SUM(dt.jumlah) as jumlah')])
      ->groupBy(['buku.isbn', 'buku.judul'])
      ->orderByDesc('jumlah')
      ->limit(7)
      ->get();

    $bukuBestSeller = $bestSeller->map(function ($buku) {
      return strlen($buku->judul) > 16 ? substr($buku->judul, 0, 16) . '...' : $buku->judul;
    })
      ->toArray();

    $jumlahBestSeller = $bestSeller->map(function ($buku) {
      return $buku->jumlah;
    })
      ->toArray();

    return [
      'buku' => collect(range(0, 6))->map(function ($i) use ($bukuBestSeller) {
        return isset($bukuBestSeller[$i]) ? $bukuBestSeller[$i] : '-';
      }),
      'jumlah' => collect(range(0, 6))->map(function ($i) use ($jumlahBestSeller) {
        return isset($jumlahBestSeller[$i]) ? $jumlahBestSeller[$i] : 0;
      })
    ];
  }

  private function getBukuMencapaiStok(): Collection
  {
    return Buku::join('detail_pengadaan as dpb', 'dpb.id_buku', '=', 'buku.id')
      ->join('pengadaan as pb', 'dpb.id_pengadaan', '=', 'pb.id')
      ->select(['buku.isbn', 'buku.judul', 'buku.jumlah', DB::raw('DATE_FORMAT(MAX(pb.tanggal), "%d-%m-%Y") as tanggal')])
      ->where('buku.jumlah', '<=', $this->batasanStok)
      ->orderByDesc('pb.tanggal')
      ->groupBy(['buku.isbn', 'buku.judul', 'buku.jumlah'])
      ->get();
  }

  private function getChartTransaksi(): array
  {
    $chartTransaksi = Transaksi::select([
      DB::raw('SUM(total_harga) AS total_perbulan'),
      DB::raw('MONTH(created_at) AS bulan')
    ])
      ->whereYear('created_at', $this->now->year)
      ->groupBy([
        DB::raw('MONTH(created_at)'),
        'bulan'
      ])
      ->orderBy('bulan')
      ->get()
      ->toArray();

    $hasil = [];

    foreach (range(1, 12) as $bulan) {
      $bulanAda = false;
      foreach ($chartTransaksi as $t) {
        if ($t['bulan'] == $bulan) {
          $bulanAda = true;
          $hasil[] = $t['total_perbulan'];
        }
      }
      if (!$bulanAda) $hasil[] = 0;
    }

    return $hasil;
  }

  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function index(): View
  {
    $pendapatanHariIni = $this->pendapatanHariIni;
    $judulBuku = $this->jumlahJudulBuku;
    $buku = $this->jumlahBuku;
    $batasanStok = $this->batasanStok;
    $aktivitasTerakhir = $this->aktivitasTerakhir;
    $transaksi = $this->transaksiHariIni->count();
    $chartTransaksi = $this->getChartTransaksi();
    $chartBestSeller = $this->getChartBestSeller();
    $bukuMencapaiStok = $this->getBukuMencapaiStok();

    return view('dasbor', compact(
      'pendapatanHariIni',
      'judulBuku',
      'buku',
      'transaksi',
      'chartTransaksi',
      'bukuMencapaiStok',
      'batasanStok',
      'chartBestSeller',
      'aktivitasTerakhir'
    ));
  }
}
