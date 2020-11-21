<?php

namespace App\Http\Controllers;

use App\Pengaturan;
use App\RiwayatAktivitas;
use Illuminate\Http\Request;

class PengaturanController extends Controller
{
	public function index()
	{
		$pengaturan = Pengaturan::first();
		return view('pengaturan.index', compact('pengaturan'));
	}

	public function update(Request $request)
	{
		$request->validate([
			'nama_toko' => 'required',
			'email' => 'required|email:rfc,dns,filter',
			'telepon' => 'required',
			'alamat' => 'required',
			'limit_stok' => 'required|min:0'
		], [
			'nama_toko.required' => 'Mohon masukan nama toko anda',
			'email.required' => 'Mohon masukan alamat email toko anda',
			'email.email' => 'Alamat email tidak valid',
			'telepon.required' => 'Mohon masukan nomor telepon toko anda',
      'alamat.required' => 'Mohon masukan alamat toko anda',
      'limit_stok.required' => 'Mohon masukan batasan stok',
      'limit_stok.min' => 'Jumlah batasan stok minimal 0'
    ]);

    $pengaturan = Pengaturan::first()->update($request->except('_token', '_method'));
    
    RiwayatAktivitas::create(['aktivitas' => 'Mengedit pengaturan']);

		return redirect('pengaturan')->with([
			'message' => $pengaturan ? 'Pengaturan toko berhasil diperbarui' : 'Gagal memperbarui pengaturan, silahkan coba lagi',
			'type' => $pengaturan ? 'success' : 'danger'
		]);
	}
}
