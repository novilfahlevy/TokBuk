<?php

namespace App\Http\Controllers\Api;

use App\Pengadaan;
use App\Transaksi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;
use App\Pengaturan;
use App\Retur;
use App\Http\Controllers\Controller;

class LaporanController extends Controller
{
  public function transaksi(Request $request)
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

  public function pengadaan(Request $request)
  {
    $pengadaan = Pengadaan::whereDate('pengadaan.tanggal', '>=', $request->dari)->whereDate('pengadaan.tanggal', '<=', $request->sampai);

    $totalPengadaan = $pengadaan->count();
    $pengeluaran = $pengadaan->sum('total_harga');
    $bukuTerbeli = $pengadaan->join('detail_pengadaan as dp', 'dp.id_pengadaan', '=', 'pengadaan.id')
      ->select(['pengadaan.id', DB::raw('SUM(dp.jumlah) as buku_terbeli')])
      ->groupBy('pengadaan.id')
      ->first()
      ->buku_terbeli ?? 0;

    foreach ($pengadaan->get() as $pengadaan) {
      $retur = $pengadaan->retur;
      if ($retur = $pengadaan->retur) {
        $pengeluaran -= $retur->total_dana_pengembalian;
        $bukuTerbeli -= $retur->detail->sum('jumlah');
      }
    }

    return response()->json([
      'status' => 200,
      'totalPengadaan' => $totalPengadaan,
      'bukuTerbeli' => (int) $bukuTerbeli,
      'pengeluaran' => (int) $pengeluaran,
      'dari' => Carbon::parse($request->dari)->format('d-m-Y'),
      'sampai' => Carbon::parse($request->sampai)->format('d-m-Y')
    ]);
  }
}