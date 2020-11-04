<?php

namespace App\Http\Controllers;

use App\Buku;
use App\DetailPembelianBuku;
use App\Exports\PembelianBukuExport;
use App\Pemasok;
use App\PembelianBuku;
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
	public function index()
	{
		$pembelian = PembelianBuku::orderBy('created_at', 'DESC')->get();
		$pemasok = Pemasok::all();
		return view('pembelian_buku.index', compact('pembelian', 'pemasok'));
	}

	public function filter(Request $request)
	{
		$pembelian = PembelianBuku::select('*');
		$pemasok = $pemasok = Pemasok::all();

		if ( $request->mulai ) {
			$pembelian->whereDate('created_at', '>=', $request->mulai);
		}
		
		if ( $request->sampai ) {
			$pembelian->whereDate('created_at', '<=', $request->sampai);
		}
		
		if ( $request->pemasok ) {
			$pembelian->where('id_pemasok', $request->pemasok);
		}

		session($request->except('_token'));

		$pembelian = $pembelian->orderBy('created_at', 'DESC')->get();

		return view('pembelian_buku.index', compact('pembelian', 'pemasok'));
	}

	public function create(Request $request)
	{
		$pemasok = Pemasok::all();

		return view('pembelian_buku.create', compact('pemasok'));
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
			'idPemasok' => 'required'
		], [
			'faktur.max' => 'Ukuran file terlalu besar, maksimal 2 MB',
			'hargaBeli.required' => 'Mohon masukan harga beli untuk pembelian buku ini',
			'idPemasok.required' => 'Mohon pilih pemasok'
		]);

		$hargaBeli = $request->hargaBeli;
		$idPemasok = $request->idPemasok;
		$bukuYangDibeli = json_decode($request->bukuYangDibeli);

		if ( $hargaBeli < $bukuYangDibeli->totalHarga ) {
			return redirect()->route('pembelian-buku.create')->withErrors(['hargaBeli' => 'Biaya untuk membeli pasokan buku dibawah kurang']);
		}

		DB::beginTransaction();

		try {
			$kode = strtoupper(Str::random(12));

			$faktur = $request->file('faktur');
			$namaFaktur = $kode . '.' . $faktur->getClientOriginalExtension();

			Storage::disk('public')->put('images/faktur/' . $namaFaktur, file_get_contents($faktur));

			$pembelianBuku = PembelianBuku::create([
				'kode' => $kode,
				'tanggal' => $request->tanggal,
				'faktur' => $namaFaktur,
				'id_user' => auth()->user()->id,
				'id_pemasok' => (int) $idPemasok,
				'total_harga' => $bukuYangDibeli->totalHarga,
				'bayar' => $hargaBeli
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
						'jumlah' => $buku->jumlah,
						'status' => 'Baru'
					]);
				} else {
					DetailPembelianBuku::create([
						'id_pembelian' => $pembelianBuku->id,
						'id_buku' => $buku->idBuku,
						'harga' => (int) $buku->harga,
						'jumlah' => $buku->jumlah,
						'status' => 'Penambahan'
					]);

					$bukuLama = Buku::find($buku->idBuku);
					$bukuLama->update(['jumlah' => $bukuLama->jumlah + $buku->jumlah]);
				}
			}

			DB::commit();

			// event(new UpdateDasborEvent);

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
			$pembelian->delete();
			DB::commit();
			return redirect()->route('pembelian-buku')->with([
				'message' => 'Berhasil Menghapus pembelian-buku',
				'type' => 'success'
			]);
		} catch ( Exception $e ) {
			DB::rollBack();
			throw new Error($e);
			return redirect()->route('pembelian-buku')->with([
				'message' => 'Gagal Menghapus pembelian-buku',
				'type' => 'danger'
			]);
		}
	}

	public function export(Request $request)
	{
		return Excel::download(new PembelianBukuExport($request->mulai, $request->sampai, $request->pemasok), 'pembelian_buku.xlsx');
	}

	public function faktur($id)
	{
		$pembelian = PembelianBuku::find($id);
		return Storage::download('images/faktur/' . $pembelian->faktur);
		// return PDF::loadView('pembelian_buku.faktur', compact('pembelian'))->download('faktur_' . $pembelian->kode . '.pdf');
	}
}