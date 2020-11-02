<?php

namespace App\Http\Controllers;

use App\Buku;
use App\DetailTransaksi;
use App\Events\UpdateDasborEvent;
use App\Events\UpdateTransaksiEvent;
use App\Exports\TransaksiExport;
use App\Transaksi;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class TransaksiController extends Controller
{
	public function getTransaksi()
	{
		return Transaksi::join('detail_transaksi as dt', 'transaksi.id', '=', 'dt.id_transaksi')
			->select([
				'transaksi.kode',
				'transaksi.created_at',
				DB::raw('SUM(dt.jumlah) AS jumlah_buku'),
				'transaksi.total_harga',
				'transaksi.uang_pembeli',
				'transaksi.id'
			])
			->groupBy([
				'transaksi.kode',
				'transaksi.created_at',
				'transaksi.total_harga', 
				'transaksi.uang_pembeli',
				'transaksi.id'
			]);
	}

	public function index()
	{
		$transaksi = $this->getTransaksi()->orderBy('created_at', 'DESC')->get();
		return view('transaksi.index', compact('transaksi'));
	}

	public function filter(Request $request)
	{
		$transaksi = $this->getTransaksi();

		if ( $request->mulai ) {
			$transaksi->whereDate('transaksi.created_at', '>=', $request->mulai);
		}
		
		if ( $request->sampai ) {
			$transaksi->whereDate('transaksi.created_at', '<=', $request->sampai);
		}

		session($request->except('_token'));

		$transaksi = $transaksi->orderBy('created_at', 'DESC')->get();

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
			$uangPembeli = $request->uangPembeli;
			$transaksi = json_decode($request->transaksi);

			if ( $transaksi->totalHarga <= 0 && !count($transaksi->buku) ) {
				return redirect()->route('transaksi.create')->withErrors(['bukuDibeli' => 'Mohon pilih paling tidak satu buku yang ingin dibeli']);
			}

			if ( $uangPembeli < $transaksi->totalHarga ) {
				return redirect()->route('transaksi.create')->withErrors(['uangPembeli' => 'Nominal uang pembeli tidak mencukupi']);
			}

			$transaksiBaru = Transaksi::create([
				'kode' => strtoupper(Str::random(12)),
				'id_user' => auth()->user()->id,
				'uang_pembeli' => $uangPembeli,
				'total_harga' => $transaksi->totalHarga
			]);

			foreach ( $transaksi->buku as $buku ) {
				$bukuLama = Buku::find($buku->idBuku);

				DetailTransaksi::create([
					'id_transaksi' => $transaksiBaru->id,
					'id_buku' => $buku->idBuku,
					'jumlah' => $buku->jumlah,
					'harga' => $buku->harga
				]);

				$bukuLama->update(['jumlah' => $bukuLama->jumlah - $buku->jumlah]);
			}

			DB::commit();

			event(new UpdateDasborEvent());

			return redirect()->route('transaksi.detail', ['id' => $transaksiBaru->id])->with([
				'message' => 'Transaksi Berhasil Dibuat.',
				'type' => 'success'
			]);
		} catch ( Exception $e ) {
			DB::rollBack();
			return redirect()->route('transaksi.create')->with([
				'message' => 'Gagal Membuat Transaksi, Silahkan Coba Lagi.',
				'type' => 'danger'
			]);
		}
	}

	public function getAllBuku() 
	{
		return response()->json([
			'status' => 200,
			'buku' => Buku::where('jumlah', '>=', 1)->whereNotNull('harga')->get()
		]);
	}

	public function destroy($id)
	{
		DB::beginTransaction();
		try {
			$transaksi = Transaksi::find($id);
			$transaksi->delete();
			DB::commit();
			return redirect()->route('transaksi')->with([
				'message' => 'Berhasil Menghapus Transaksi',
				'type' => 'success'
			]);
		} catch ( Exception $e ) {
			DB::rollBack();
			return redirect()->route('transaksi')->with([
				'message' => 'Gagal Menghapus Transaksi',
				'type' => 'danger'
			]);
		}
	}

	public function export(Request $request)
	{
		return Excel::download(new TransaksiExport($request->mulai, $request->sampai), 'transaksi.xlsx');
	}
}
