<?php

namespace App\Http\Controllers;

use App\Buku;
use App\DetailTransaksi;
use App\Exports\TransaksiExport;
use App\Transaksi;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class TransaksiController extends Controller
{
	public function index()
	{
		$transaksi = Transaksi::orderBy('created_at', 'DESC')->get();
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

			return redirect()->route('transaksi')->with([
				'message' => 'Transaksi berhasil dibuat.',
				'type' => 'success'
			]);
		} catch ( Exception $e ) {
			DB::rollBack();
			return redirect()->route('transaksi.create')->with([
				'message' => 'Gagal membuat transaksi, silahkan coba lagi.',
				'type' => 'danger'
			]);
		}
	}

	public function getAllBuku() 
	{
		return response()->json([
			'status' => 200,
			'buku' => Buku::where('jumlah', '>=', 1)->get()
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
				'message' => 'Berhasil menghapus transaksi',
				'type' => 'success'
			]);
		} catch ( Exception $e ) {
			DB::rollBack();
			return redirect()->route('transaksi')->with([
				'message' => 'Gagal menghapus transaksi',
				'type' => 'danger'
			]);
		}
	}

	public function export(Request $request)
	{
		return Excel::download(new TransaksiExport($request->mulai, $request->sampai), 'transaksi.xlsx');
	}
}
