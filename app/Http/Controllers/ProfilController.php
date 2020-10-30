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
			'username' => 'required',
			'alamat' => 'required',
			'email' => 'required|email:rfc,dns,filter',
			'telepon' => 'required'
		], [
			'name.required' => 'Masukan nama lengkap anda',
			'username.required' => 'Masukan username anda',
			'alamat.required' => 'Masukan alamat anda',
			'email.required' => 'Masukan alamat email anda',
			'email.email' => 'Mohon masukan email yang valid',
			'telepon.required' => 'Masukan nomor telepon anda'
		]);

		$user = User::find(auth()->user()->id);

		if ( $user->update($request->all()) ) {
			return redirect()->route('profil')->with([
				'message' => 'Profil anda berhasil diganti.', 
				'type' => 'success'
			]);
		}

		return redirect()->route('profil')->with([
			'message' => 'Gagal mengganti profil anda, silahkan coba lagi.', 
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
					'message' => 'Password anda berhasil diganti.', 
					'type' => 'success'
				]);
			}
			return redirect()->route('profil')->withErrors([
				'message' => 'Gagal mengganti password, silahkan coba lagi.',
				'type' => 'danger'
			]);
		}

		return redirect()->route('profil')->withErrors(['passwordLama' => 'Password lama anda tidak tepat']);
	}
}