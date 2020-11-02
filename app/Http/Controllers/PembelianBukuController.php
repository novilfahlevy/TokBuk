<?php

namespace App\Http\Controllers;

use App\Buku;
use App\DetailPembelianBuku;
use App\Events\UpdateDasborEvent;
use App\Exports\PembelianBukuExport;
use App\Pemasok;
use App\PembelianBuku;
use Error;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class PembelianBukuController extends Controller
{
	public function index()
	{
		$pembelian = PembelianBuku::orderBy('created_at', 'DESC')->get();
		return view('pembelian_buku.index', compact('pembelian'));
	}

	public function filter(Request $request)
	{
		$pembelian = PembelianBuku::select('*');

		if ( $request->mulai ) {
			$pembelian->whereDate('created_at', '>=', $request->mulai);
		}
		
		if ( $request->sampai ) {
			$pembelian->whereDate('created_at', '<=', $request->sampai);
		}

		$pembelian = $pembelian->orderBy('created_at', 'DESC')->get();

		return view('pembelian_buku.index', compact('pembelian'));
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
		$hargaBeli = $request->hargaBeli;
		$idPemasok = $request->idPemasok;
		$bukuYangDibeli = json_decode($request->bukuYangDibeli);

		if ( $hargaBeli < $bukuYangDibeli->totalHarga ) {
			return redirect()->route('pembelian-buku.create')->withErrors(['hargaBeli' => 'Biaya untuk membeli pasokan buku dibawah kurang']);
		}

		DB::beginTransaction();

		try {
			$pembelianBuku = PembelianBuku::create([
				'kode' => strtoupper(Str::random(12)),
				'id_user' => auth()->user()->id,
				'id_pemasok' => (int) $idPemasok,
				'total_harga_jual' => $bukuYangDibeli->totalHarga,
				'harga_beli' => $hargaBeli
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
						'id_pembelian_buku' => $pembelianBuku->id,
						'id_buku' => $bukuBaru->id,
						'harga_jual' => (int) $buku->harga,
						'jumlah' => $buku->jumlah,
						'status' => 'Baru'
					]);
				} else {
					DetailPembelianBuku::create([
						'id_pembelian_buku' => $pembelianBuku->id,
						'id_buku' => $buku->idBuku,
						'harga_jual' => (int) $buku->harga,
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
		return Excel::download(new PembelianBukuExport($request->mulai, $request->sampai), 'pembelian-buku.xlsx');
	}
}
