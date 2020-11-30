<?php

namespace App\Http\Controllers;

use App\Buku;
use App\DetailTransaksi;
use App\Exports\TransaksiExport;
use App\Pengaturan;
use App\Traits\RiwayatAktivitas;
use App\Transaksi;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade as PDF;
use Error;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;

class TransaksiController extends Controller
{
  use RiwayatAktivitas;

  public function getIndexTransaksiBuilder(): Builder
  {
    return Transaksi::join('detail_transaksi as dt', 'transaksi.id', '=', 'dt.id_transaksi')
      ->select([
        'transaksi.kode',
        'transaksi.created_at',
        DB::raw('SUM(dt.jumlah) AS jumlah_buku'),
        'transaksi.total_harga',
        'transaksi.bayar',
        'transaksi.id',
      ])
      ->groupBy([
        'transaksi.kode',
        'transaksi.created_at',
        'transaksi.total_harga',
        'transaksi.bayar',
        'transaksi.id',
      ])
      ->orderByDesc('transaksi.created_at');
  }

  public function index()
  {
    $transaksi = $this->getIndexTransaksiBuilder()->get();
    return $_GET ? $this->filter() : view('transaksi.index', compact('transaksi'));
  }

  public function filter(): View
  {
    $transaksi = $this->getIndexTransaksiBuilder();

    if ($mulai = $_GET['mulai']) {
      $transaksi->whereDate('transaksi.created_at', '>=', $mulai);
    }

    if ($sampai = $_GET['sampai']) {
      $transaksi->whereDate('transaksi.created_at', '<=', $sampai);
    }

    session($_GET);
    $transaksi = $transaksi->get();

    return view('transaksi.index', compact('transaksi'));
  }

  public function detail($id)
  {
    $transaksi = Transaksi::find($id);
    return view('transaksi.detail', compact('transaksi'));
  }

  public function create()
  {
    return view('transaksi.create');
  }

  public function store(Request $request)
  {
    DB::beginTransaction();

    try {
      $nominalPembayaran = $request->bayar;
      $transaksiRequest = json_decode($request->transaksi);

      if ($error = $this->validateTransaksi($nominalPembayaran, $transaksiRequest)) {
        return $error;
      }

      $kode = $this->getKodeTransaksi();

      $transaksiBaru = Transaksi::create([
        'kode' => $kode,
        'bayar' => $nominalPembayaran,
        'total_harga' => $transaksiRequest->totalHarga
      ]);

      $this->createDetailTransaksi($transaksiBaru->id, $transaksiRequest);

      DB::commit();

      $this->rekamAktivitas('Membuat transaksi ' . $kode);

      return redirect()->route('transaksi.detail', ['id' => $transaksiBaru->id])->with([
        'message' => 'Transaksi Berhasil Dibuat.',
        'type' => 'success'
      ]);
    } catch (Exception $e) {
      DB::rollBack();
      throw new Error($e);
      return redirect()->route('transaksi.create')->with([
        'message' => 'Gagal Membuat Transaksi, Silahkan Coba Lagi.',
        'type' => 'danger'
      ]);
    }
  }

  private function validateTransaksi($nominalPembayaran, $transaksiRequest)
  {
    if ($transaksiRequest->totalHarga <= 0 && !count($transaksiRequest->buku)) {
      return redirect()
        ->route('transaksi.create')
        ->withErrors(['bukuDibeli' => 'Mohon pilih paling tidak satu buku yang ingin dibeli']);
    }

    if ($nominalPembayaran < $transaksiRequest->totalHarga) {
      return redirect()
        ->route('transaksi.create')
        ->withErrors(['bayar' => 'Nominal pembayaran tidak mencukupi']);
    }

    return false;
  }

  private function getKodeTransaksi()
  {
    $kodeTerakhir = Transaksi::latest()->first();
    $kodeTerakhir = $kodeTerakhir ? $kodeTerakhir->kode : 'T00001';
    $jumlahTransaksi = Transaksi::count() + 2;
    return substr($kodeTerakhir, 0, -count(str_split((string) $jumlahTransaksi))) . $jumlahTransaksi;
  }

  private function createDetailTransaksi($idTransaksi, $transaksiRequest): void
  {
    foreach ($transaksiRequest->buku as $buku) {
      $bukuLama = Buku::find($buku->idBuku);

      DetailTransaksi::create([
        'id_transaksi' => $idTransaksi,
        'id_buku' => $buku->idBuku,
        'jumlah' => $buku->jumlah,
        'harga' => $bukuLama->harga,
        'diskon' => $buku->diskon ?? null
      ]);

      $bukuLama->update(['jumlah' => $bukuLama->jumlah - $buku->jumlah]);
    }
  }

  public function destroy($id)
  {
    DB::beginTransaction();
    try {
      $transaksi = Transaksi::find($id)-;
      $kode = $transaksi->kode;

      $this->kembalikanJumlahBuku($transaksi);
      $transaksi->delete();

      DB::commit();

      $this->rekamAktivitas('Menghapus transaksi ' . $kode);

      return redirect()->route('transaksi')->with([
        'message' => 'Berhasil Menghapus Transaksi',
        'type' => 'success'
      ]);
    } catch (Exception $e) {
      DB::rollBack();
      return redirect()->route('transaksi')->with([
        'message' => 'Gagal Menghapus Transaksi',
        'type' => 'danger'
      ]);
    }
  }

  private function kembalikanJumlahBuku($transaksi)
  {
    foreach ($transaksi->detail as $detail) {
      if ($buku = $detail->buku) {
        $buku->update(['jumlah' => $buku->jumlah + $detail->jumlah]);
      }
    }
  }

  public function export(Request $request)
  {
    return Excel::download(new TransaksiExport($request->mulai, $request->sampai), 'transaksi.xlsx');
  }

  public function nota($id)
  {
    $transaksi = Transaksi::find($id);
    $pengaturan = Pengaturan::first();
    return PDF::loadView('transaksi.nota', compact('transaksi', 'pengaturan'))->download('nota_' . $transaksi->kode . '.pdf');
  }

  public function cetak($id)
  {
    $transaksi = Transaksi::find($id);
    $pengaturan = Pengaturan::first();
    return view('transaksi.cetak', compact('transaksi', 'pengaturan'));
  }
}
