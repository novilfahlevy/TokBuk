<?php

namespace App\Http\Controllers;

use App\Buku;
use App\DetailPengadaan;
use App\Events\UpdateDasborEvent;
use App\Exports\PengadaanExport;
use App\Distributor;
use App\Pengadaan;
use App\Pengaturan;
use Error;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Storage;

class PengadaanController extends Controller
{
	private function getPengadaan()
	{
		return Pengadaan::join('detail_pengadaan as dp', 'dp.id_pengadaan', '=', 'pengadaan.id')
		->select([
			'pengadaan.id',
			'pengadaan.kode',
			'pengadaan.tanggal',
			'pengadaan.id_distributor',
			'pengadaan.bayar',
			'pengadaan.total_harga',
			DB::raw('SUM(dp.jumlah) as jumlah_buku')
		])
		->groupBy([
			'pengadaan.id',
			'pengadaan.kode',
			'pengadaan.tanggal',
			'pengadaan.id_distributor',
			'pengadaan.bayar',
			'pengadaan.total_harga'
		]);
	}

	public function index()
	{
		$pembelian = $this->getPengadaan()->orderBy('tanggal')->get();
		$distributor = Distributor::all();
		return view('pengadaan.index', compact('pembelian', 'distributor'));
	}

	public function filter(Request $request)
	{
		$pembelian = $this->getPengadaan();
		$distributor = Distributor::all();

		if ( $request->mulai ) {
			$pembelian->whereDate('tanggal', '>=', $request->mulai);
		}
		
		if ( $request->sampai ) {
			$pembelian->whereDate('tanggal', '<=', $request->sampai);
		}
		
		if ( $request->distributor ) {
			$pembelian->where('id_distributor', $request->distributor);
		}

		session($request->except('_token'));

		$pembelian = $pembelian->orderBy('tanggal', 'DESC')->get();

		return view('pengadaan.index', compact('pembelian', 'distributor'));
	}

	public function create(Request $request)
	{
		$distributor = Distributor::all();

		return view('pengadaan.create', compact('distributor'));
	}

	public function detail($id)
	{
		$pembelian = Pengadaan::find($id);
		return view('pengadaan.detail', compact('pembelian'));
	}

	public function store(Request $request)
	{
		$request->validate([
			'faktur' => 'max:2048',
			'hargaBeli' => 'required',
			'idDistributor' => 'required'
		], [
			'faktur.max' => 'Ukuran file terlalu besar, maksimal 2 MB',
			'hargaBeli.required' => 'Mohon masukan harga beli untuk pengadaan ini',
			'idDistributor.required' => 'Mohon pilih distributor'
		]);

		$hargaBeli = $request->hargaBeli;
		$idDistributor = $request->idDistributor;
		$bukuYangDibeli = json_decode($request->bukuYangDibeli);

		if ( $hargaBeli < $bukuYangDibeli->totalHarga ) {
			return redirect()->route('pengadaan.create')->withErrors(['hargaBeli' => 'Biaya untuk membeli pasokan buku dibawah kurang']);
		}

		DB::beginTransaction();

		try {
			$jumlahPengadaan = Pengadaan::withTrashed()->count() + 1;
			$kode = substr('P00000000000', 0, -count(str_split((string) $jumlahPengadaan))) . $jumlahPengadaan;

			$faktur = $request->file('faktur');
			$namaFaktur = $kode . '.' . $faktur->getClientOriginalExtension();

			Storage::disk('public')->put('images/faktur/' . $namaFaktur, file_get_contents($faktur));

			$pengadaan = Pengadaan::create([
				'kode' => $kode,
				'tanggal' => $request->tanggal,
				'faktur' => $namaFaktur,
				'id_user' => auth()->user()->id,
				'id_distributor' => (int) $idDistributor,
				'total_harga' => $bukuYangDibeli->totalHarga,
				'bayar' => $hargaBeli,
				'keterangan' => $request->keterangan
			]);

			foreach ( $bukuYangDibeli->buku as $buku ) {
				if ( $buku->status === 'Baru' ) {
					$bukuBaru = Buku::create([
						'sampul' => 'sampul.png',
						'isbn' => $buku->isbn,
						'judul' => $buku->judul,
						'jumlah' => $buku->jumlah
					]);

					DetailPengadaan::create([
						'id_pengadaan' => $pengadaan->id,
						'id_buku' => $bukuBaru->id,
						'harga' => (int) $buku->harga,
						'jumlah' => $buku->jumlah
					]);
				} else {
					DetailPengadaan::create([
						'id_pengadaan' => $pengadaan->id,
						'id_buku' => $buku->idBuku,
						'harga' => (int) $buku->harga,
						'jumlah' => $buku->jumlah
					]);

					$bukuLama = Buku::find($buku->idBuku);
					$bukuLama->update(['jumlah' => $bukuLama->jumlah + $buku->jumlah]);
				}
			}

			DB::commit();

			event(new UpdateDasborEvent);

			return redirect()->route('pengadaan.detail', ['id' => $pengadaan->id])->with([
				'type' => 'success',
				'message' => 'Pengadaan Berhasil Dilakukan.'
			]);
		} catch ( Exception $e ) {
			DB::rollBack();
			throw new Error($e);
			return redirect()->route('pengadaan.create')->with([
				'type' => 'danger',
				'message' => 'Gagal Melakukan Pengadaan, Silahkan coba lagi.'
			]);
		}
	}

	public function destroy($id)
	{
		DB::beginTransaction();
		try {
			$pengadaan = Pengadaan::find($id);

			foreach ( $pengadaan->detail as $detailPengadaan ) {
				$buku = Buku::find($detailPengadaan->id_buku);
				if ( !!$buku ) {
          if ( $buku->jumlah < $detailPengadaan->jumlah ) {
            $buku->update(['jumlah' => 0]);
          } else {
            $buku->update(['jumlah' => $buku->jumlah - $detailPengadaan->jumlah]);
          }
        }
			}

			$pengadaan->delete();

			DB::commit();

			event(new UpdateDasborEvent);
			return redirect()->route('pengadaan')->with([
				'message' => 'Berhasil Menghapus Pengadaan',
				'type' => 'success'
			]);
		} catch ( Exception $e ) {
			DB::rollBack();
			throw new Error($e);
			return redirect()->route('pengadaan')->with([
				'message' => 'Gagal Menghapus Pengadaan',
				'type' => 'danger'
			]);
		}
	}

	public function export(Request $request)
	{
		return Excel::download(new PengadaanExport($request->mulai, $request->sampai, $request->distributor), 'pengadaan.xlsx');
	}

	public function faktur($id)
	{
		$pembelian = Pengadaan::find($id);
		return Storage::download('images/faktur/' . $pembelian->faktur);
	}
	
	public function laporan($id)
	{
		$pembelian = Pengadaan::find($id);
		$pengaturan = Pengaturan::first();
		return PDF::loadView('pengadaan.faktur', compact('pembelian', 'pengaturan'))->download('laporan_' . $pembelian->kode . '.pdf');
	}

	public function getAllBuku() 
	{
		return response()->json([
			'status' => 200,
			'buku' => Buku::get()
		]);
  }
  
  public function cetak($id)
  {
    $pembelian = Pengadaan::find($id);
		$pengaturan = Pengaturan::first();
		return view('pengadaan.cetak', compact('pembelian', 'pengaturan'));
  }
}