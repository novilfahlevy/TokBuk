<?php

namespace App\Http\Controllers;

use App\Buku;
use App\DetailPembelianBuku;
use App\Events\UpdateDasborEvent;
use App\Exports\PembelianBukuExport;
use App\Distributor;
use App\PembelianBuku;
use App\Pengaturan;
use Error;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Storage;

class PembelianBukuController extends Controller
{
	private function getPembelianBuku()
	{
		return PembelianBuku::join('detail_pembelian_buku as dp', 'dp.id_pembelian', '=', 'pembelian_buku.id')
		->select([
			'pembelian_buku.id',
			'pembelian_buku.kode',
			'pembelian_buku.tanggal',
			'pembelian_buku.id_distributor',
			'pembelian_buku.bayar',
			'pembelian_buku.total_harga',
			DB::raw('SUM(dp.jumlah) as jumlah_buku')
		])
		->groupBy([
			'pembelian_buku.id',
			'pembelian_buku.kode',
			'pembelian_buku.tanggal',
			'pembelian_buku.id_distributor',
			'pembelian_buku.bayar',
			'pembelian_buku.total_harga'
		]);
	}

	public function index()
	{
		$pembelian = $this->getPembelianBuku()->orderBy('tanggal', 'DESC')->get();
		$distributor = Distributor::all();
		return view('pembelian_buku.index', compact('pembelian', 'distributor'));
	}

	public function filter(Request $request)
	{
		$pembelian = $this->getPembelianBuku();
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

		return view('pembelian_buku.index', compact('pembelian', 'distributor'));
	}

	public function create(Request $request)
	{
		$distributor = Distributor::all();

		return view('pembelian_buku.create', compact('distributor'));
	}

	public function detail($id)
	{
		$pembelian = PembelianBuku::find($id);
		return view('pembelian_buku.detail', compact('pembelian'));
	}

	public function store(Request $request)
	{
		$request->validate([
			'faktur' => 'max:2048',
			'hargaBeli' => 'required',
			'idDistributor' => 'required'
		], [
			'faktur.max' => 'Ukuran file terlalu besar, maksimal 2 MB',
			'hargaBeli.required' => 'Mohon masukan harga beli untuk pembelian buku ini',
			'idDistributor.required' => 'Mohon pilih distributor'
		]);

		$hargaBeli = $request->hargaBeli;
		$idDistributor = $request->idDistributor;
		$bukuYangDibeli = json_decode($request->bukuYangDibeli);

		if ( $hargaBeli < $bukuYangDibeli->totalHarga ) {
			return redirect()->route('pembelian-buku.create')->withErrors(['hargaBeli' => 'Biaya untuk membeli pasokan buku dibawah kurang']);
		}

		DB::beginTransaction();

		try {
			$jumlahPembelianBuku = PembelianBuku::count() + 1;
			$kode = substr('P000000000', 0, -count(str_split((string) $jumlahPembelianBuku))) . $jumlahPembelianBuku;

			$faktur = $request->file('faktur');
			$namaFaktur = $kode . '.' . $faktur->getClientOriginalExtension();

			Storage::disk('public')->put('images/faktur/' . $namaFaktur, file_get_contents($faktur));

			$pembelianBuku = PembelianBuku::create([
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

					DetailPembelianBuku::create([
						'id_pembelian' => $pembelianBuku->id,
						'id_buku' => $bukuBaru->id,
						'harga' => (int) $buku->harga,
						'jumlah' => $buku->jumlah
					]);
				} else {
					DetailPembelianBuku::create([
						'id_pembelian' => $pembelianBuku->id,
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

			return redirect()->route('pembelian-buku.detail', ['id' => $pembelianBuku->id])->with([
				'type' => 'success',
				'message' => 'Pembelian Buku Berhasil Dilakukan.'
			]);
		} catch ( Exception $e ) {
			DB::rollBack();
			throw new Error($e);
			return redirect()->route('pembelian-buku.create')->with([
				'type' => 'danger',
				'message' => 'Gagal Melakukan Pembelian Buku, Silahkan coba lagi.'
			]);
		}
	}

	public function destroy($id)
	{
		DB::beginTransaction();
		try {
			$pembelian = PembelianBuku::find($id);

			foreach ( $pembelian->detail as $detailPembelian ) {
				$buku = Buku::find($detailPembelian->id_buku);
				if ( $buku->jumlah < $detailPembelian->jumlah ) {
					$buku->update(['jumlah' => 0]);
				} else {
					$buku->update(['jumlah' => $buku->jumlah - $detailPembelian->jumlah]);
				}
			}

			$pembelian->delete();

			DB::commit();

			event(new UpdateDasborEvent);
			return redirect()->route('pembelian-buku')->with([
				'message' => 'Berhasil Menghapus Pembelian Buku',
				'type' => 'success'
			]);
		} catch ( Exception $e ) {
			DB::rollBack();
			throw new Error($e);
			return redirect()->route('pembelian-buku')->with([
				'message' => 'Gagal Menghapus Pembelian Buku',
				'type' => 'danger'
			]);
		}
	}

	public function export(Request $request)
	{
		return Excel::download(new PembelianBukuExport($request->mulai, $request->sampai, $request->distributor), 'pembelian_buku.xlsx');
	}

	public function faktur($id)
	{
		$pembelian = PembelianBuku::find($id);
		return Storage::download('images/faktur/' . $pembelian->faktur);
	}
	
	public function laporan($id)
	{
		$pembelian = PembelianBuku::find($id);
		$pengaturan = Pengaturan::first();
		return PDF::loadView('pembelian_buku.faktur', compact('pembelian', 'pengaturan'))->download('laporan_' . $pembelian->kode . '.pdf');
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
    $pembelian = PembelianBuku::find($id);
		$pengaturan = Pengaturan::first();
		return view('pembelian_buku.cetak', compact('pembelian', 'pengaturan'));
  }
}