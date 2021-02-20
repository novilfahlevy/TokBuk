<?php

namespace App\Http\Controllers;

use App\Buku;
use App\DetailRetur;
use App\Pengadaan;
use App\Pengaturan;
use App\Retur;
use App\Traits\RiwayatAktivitas;
use Barryvdh\DomPDF\Facade as PDF;
use Error;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReturController extends Controller
{
  use RiwayatAktivitas;

  private function getIndexReturBuilder(): Builder
  {
    return Retur::join('detail_retur as dr', 'dr.id_retur', '=', 'retur.id')
      ->select([
        'retur.id',
        'retur.kode',
        'retur.tanggal',
        'retur.total_dana_pengembalian',
        'retur.id_pengadaan',
        DB::raw('SUM(dr.jumlah) as jumlah')
      ])
      ->groupBy([
        'retur.id',
        'retur.kode',
        'retur.tanggal',
        'retur.id_pengadaan',
        'retur.total_dana_pengembalian',
      ])
      ->orderByDesc('retur.tanggal');
  }

  public function index()
  {
    $returs = $this->getIndexReturBuilder()->get();
    return view('retur.index', compact('returs'));
  }

  public function detail($id)
  {
    $retur = Retur::find($id);
    return view('retur.detail', compact('retur'));
  }

  public function create($id)
  {
    $pengadaan = Pengadaan::find($id);
    return view('retur.create', compact('pengadaan'));
  }

  public function store(Request $request, $id)
  {
    DB::beginTransaction();

    try {
      $retur = json_decode($request->retur);

      $kode = $this->getKodeRetur();

      $returBaru = Retur::create([
        'kode' => $kode,
        'id_pengadaan' => $id,
        'total_dana_pengembalian' => $retur->danaPengembalian,
        'tanggal' => $retur->tanggal
      ]);

      $this->createDetailRetur($returBaru->id, $retur->buku);

      DB::commit();

      $this->rekamAktivitas('Membuat retur ' . $kode);

      return redirect()->route('retur.detail', ['id' => $returBaru->id])->with([
        'message' => 'Retur Berhasil Dibuat.',
        'type' => 'success'
      ]);
    } catch (Exception $e) {
      DB::rollBack();
      throw new Error($e);
      return redirect()->route('retur.create')->with([
        'message' => 'Gagal Membuat Retur, Silahkan Coba Lagi.',
        'type' => 'danger'
      ]);
    }
  }

  private function getKodeRetur()
  {
    $jumlahRetur = Retur::count() + 2;
    $kodeTerakhir = Retur::latest()->first();
    $kodeTerakhir = $kodeTerakhir ? $kodeTerakhir->kode : 'T0001';
    return substr($kodeTerakhir, 0, -count(str_split((string) $jumlahRetur))) . $jumlahRetur;
  }

  private function createDetailRetur($idReturBaru, $returRequestBuku)
  {
    foreach ($returRequestBuku as $buku) {
      $bukuLama = Buku::find($buku->idBuku);

      DetailRetur::create([
        'id_retur' => $idReturBaru,
        'id_detail_pengadaan' => $buku->idDetailPengadaan,
        'dana_pengembalian' => $buku->harga,
        'jumlah' => $buku->jumlah,
        'keterangan' => $buku->keterangan
      ]);

      $bukuLama->update(['jumlah' => $bukuLama->jumlah - $buku->jumlah]);
    }
  }

  public function destroy($id)
  {
    DB::beginTransaction();
    try {
      $retur = Retur::find($id);
      $kode = $retur->kode;

      $this->kembalikanJumlahBuku($retur->detail);
      $retur->delete();

      DB::commit();

      $this->rekamAktivitas('Menghapus retur ' . $kode);

      return redirect()->route('retur')->with([
        'message' => 'Berhasil Menghapus retur',
        'type' => 'success'
      ]);
    } catch (Exception $e) {
      DB::rollBack();
      return redirect()->route('retur')->with([
        'message' => 'Gagal Menghapus retur',
        'type' => 'danger'
      ]);
    }
  }

  private function kembalikanJumlahBuku($detailRetur)
  {
    foreach ($detailRetur as $detail) {
      if ($buku = $detail->pengadaan->buku) {
        $buku->update(['jumlah' => $buku->jumlah + $detail->jumlah]);
      }
    }
  }

  public function faktur($id)
  {
    $retur = Retur::find($id);
    $pengaturan = Pengaturan::first();
    return PDF::loadView('retur.faktur', compact('retur', 'pengaturan'))->download('faktur_' . $retur->kode . '.pdf');
  }

  public function cetak($id)
  {
    $retur = Retur::find($id);
    $pengaturan = Pengaturan::first();
    return view('retur.cetak', compact('retur', 'pengaturan'));
  }
}
