<?php

namespace App\Http\Controllers;

use App\Buku;
use App\DetailRetur;
use App\Pengadaan;
use App\Pengaturan;
use App\Retur;
use App\RiwayatAktivitas;
use Barryvdh\DomPDF\Facade as PDF;
use Error;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReturController extends Controller
{
  public function index()
  {
    $returs = Retur::join('detail_retur as dr', 'dr.id_retur', '=', 'retur.id')
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
      ->orderByDesc('retur.tanggal')
      ->get(); 
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

      $jumlahRetur = Retur::count() + 2;
      $kodeTerakhir = Retur::latest()->first();
      $kodeTerakhir = $kodeTerakhir ? $kodeTerakhir->kode : 'T0001';
			$kode = substr($kodeTerakhir, 0, -count(str_split((string) $jumlahRetur))) . $jumlahRetur;

			$returBaru = Retur::create([
        'kode' => $kode,
        'id_pengadaan' => $retur->idPengadaan,
				'id_user' => auth()->user()->id,
        'total_dana_pengembalian' => $retur->danaPengembalian,
        'tanggal' => $retur->tanggal
			]);

			foreach ( $retur->buku as $buku ) {
        $bukuLama = Buku::find($buku->idBuku);

				DetailRetur::create([
					'id_retur' => $returBaru->id,
					'id_detail_pengadaan' => $buku->idDetailPengadaan,
					'dana_pengembalian' => $buku->harga,
          'jumlah' => $buku->jumlah,
          'keterangan' => $buku->keterangan
				]);

				$bukuLama->update(['jumlah' => $bukuLama->jumlah - $buku->jumlah]);
			}

      DB::commit();
      
      RiwayatAktivitas::create(['aktivitas' => 'Membuat retur ' . $kode]);

			return redirect()->route('retur.detail', ['id' => $returBaru->id])->with([
				'message' => 'Retur Berhasil Dibuat.',
				'type' => 'success'
			]);
		} catch ( Exception $e ) {
			DB::rollBack();
			throw new Error($e);
			return redirect()->route('retur.create')->with([
				'message' => 'Gagal Membuat Retur, Silahkan Coba Lagi.',
				'type' => 'danger'
			]);
		}
  }

  public function getDataBukuApi($id)
  {
    $buku = Pengadaan::where('pengadaan.id', $id)
      ->join('detail_pengadaan as dp', 'dp.id_pengadaan', '=', 'pengadaan.id')
      ->join('buku', 'dp.id_buku', '=', 'buku.id')
      ->select(['buku.*', 'dp.jumlah as jumlah', 'dp.harga as harga', 'dp.id as id_pengadaan'])
      ->where('buku.jumlah', '>=', 1)
      ->get();
    
    return response()->json([
			'status' => 200,
			'buku' => $buku
		]);
  }

  public function destroy($id)
  {
    DB::beginTransaction();
		try {
      $retur = Retur::find($id);
      $kode = $retur->kode;

			foreach ( $retur->detail as $detail ) {
				if ( $buku = $detail->pengadaan->buku ) {
					$buku->update(['jumlah' => $buku->jumlah + $detail->jumlah]);
				}
			}

      $retur->delete();
      
      DB::commit();
      
      RiwayatAktivitas::create(['aktivitas' => 'Menghapus retur ' . $kode]);

			return redirect()->route('retur')->with([
				'message' => 'Berhasil Menghapus retur',
				'type' => 'success'
			]);
		} catch ( Exception $e ) {
			DB::rollBack();
			return redirect()->route('retur')->with([
				'message' => 'Gagal Menghapus retur',
				'type' => 'danger'
			]);
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
		return view ('retur.cetak', compact('retur', 'pengaturan'));
  }
}
