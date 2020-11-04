<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfilController extends Controller
{
	public function index()
	{
		$user = auth()->user();
		return view('profil.index', compact('user'));
	}

	public function update(Request $request)
	{
	  $request->validate([
			'name' => 'required',
			'username' => 'unique:users,username,{$id},id,deleted_at,NULL',
			'alamat' => 'required',
			'email' => 'unique:users,email,{$id},id,deleted_at,NULL',
			'telepon' => 'required'
		], [
			'name.required' => 'Masukan nama lengkap anda',
			// 'username.required' => 'Masukan username anda',
			'username.unique' => 'Username sudah dipakai',
			'alamat.required' => 'Masukan alamat anda',
			// 'email.required' => 'Masukan alamat email anda',
			'email.email' => 'Mohon masukan email yang valid',
			'email.unique' => 'Email sudah dipakai',
			'telepon.required' => 'Masukan nomor telepon anda'
		]);

		$user = User::find(auth()->user()->id);

		if ( 
			$user->update([
				'name' => $request->name,
				'username' => $request->username ?? $user->first()->username,
				'email' => $request->email ?? $user->first()->email,
				'alamat' => $request->alamat,
				'telepon' => $request->telepon
			]) 
		) {
			return redirect()->route('profil')->with([
				'message' => 'Profil Anda Berhasil Diganti.', 
				'type' => 'success'
			]);
		}

		return redirect()->route('profil')->with([
			'message' => 'Gagal Mengganti Profil Anda, Silahkan Coba Lagi.', 
			'type' => 'danger'
		]);
	}

	public function changePassword(Request $request)
	{
		$request->validate([
			'passwordLama' => 'required',
			'password' => 'required|confirmed|min:8'
		], [
			'passwordLama.required' => 'Masukan password lama anda',
			'password.required' => 'Masukan password baru anda',
			'password.confirmed' => 'Password tidak cocok, harap konfirmasi ulang password anda',
			'password.min' => 'Password harus berisi minimal 8 karakter'
		]);

		$user = User::find(auth()->user()->id);

		if ( Hash::check($request->passwordLama, $user->password) ) {
			if ( $user->update(['password' => Hash::make($request->password)]) ) {
				return redirect()->route('profil')->with([
					'message' => 'Password Anda Berhasil Diganti.', 
					'type' => 'success'
				]);
			}
			return redirect()->route('profil')->withErrors([
				'message' => 'Gagal Mengganti Password, Silahkan Coba Lagi.',
				'type' => 'danger'
			]);
		}

		return redirect()->route('profil')->withErrors(['passwordLama' => 'Password Lama Anda Tidak Tepat']);
	}
}