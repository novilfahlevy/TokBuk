<?php

namespace App\Http\Controllers;

use App\Pengadaan;
use App\Retur;
use App\RiwayatAktivitas;
use App\Transaksi;
use Illuminate\Http\Request;
use App\User;
use Error;
use Exception;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
  public function __construct(User $user)
  {
    $this->user = $user;
  }
  public function index()
  {
    $users = $this->user->orderBy(DB::raw('CASE WHEN id = ' . auth()->user()->id . ' THEN 0 ELSE 1 END'))->get();
    return view('user.index', compact('users'));
  }

  public function create()
  {
    return view('user.create');
  }

  public function store(Request $request)
  {
    $request->validate([
      'name' => 'required',
      'username' => 'required|unique:users,username,{$id},id',
      'posisi' => 'required',
      'email' => 'required|unique:users,email,{$id},id',
      'telepon' => 'required',
      'alamat' => 'required',
      'password' => 'required|confirmed|min:6'
    ]);

    $insert = User::insert([
      'name' => $request->name,
      'username' => $request->username,
      'posisi' => $request->posisi,
      'email'   => $request->email,
      'telepon'   => $request->telepon,
      'alamat'   => $request->alamat,
      'password' => bcrypt($request->password)
    ]);

    if ($insert == true) {
      RiwayatAktivitas::create(['aktivitas' => 'Menambahkan pengguna ' . $request->name]);
      return redirect()->route('user')->with(['message' => 'Berhasil Menambah Pengguna', 'type' => 'success']);
    } else {
      return redirect()->route('user')->with(['message' => 'Gagal Menambah Pengguna', 'type' => 'danger']);
    }
  }

  public function edit($id)
  {
    $user = User::where('id', $id)->first();
    return view('user.edit', compact('user'));
  }

  public function update(Request $request, $id)
  {

    $request->validate([
      'name' => 'required',
      'username' => 'unique:users,username,{$id},id',
      'posisi' => 'required',
      'email' => 'unique:users,email,{$id},id',
      'alamat' => 'required',
      'telepon' => 'required'
    ]);

    $user = User::where('id', $id);

    $update = $user->update([
      'name' => $request->name,
      'username' => $request->username ?? $user->first()->username,
      'posisi' => $request->posisi,
      'email' => $request->email ?? $user->first()->email,
      'alamat' => $request->alamat,
      'telepon' => $request->telepon
    ]);

    if ($update == true) {
      RiwayatAktivitas::create(['aktivitas' => 'Mengedit pengguna ' . $request->name]);
      return redirect()->route('user')->with(['message' => 'Berhasil Mengedit Pengguna', 'type' => 'success']);
    } else {
      return redirect()->route('user')->with(['message' => 'Gagal Mengedit Pengguna', 'type' => 'danger']);
    }
  }

  public function destroy($id)
  {
    DB::beginTransaction();

    try {
      $user = User::find($id);
      $nama = $user->name;

      RiwayatAktivitas::create(['aktivitas' => 'Menghapus pengguna ' . $nama]);

      Transaksi::where('id_user', $id)->update(['id_user' => null]);
      Pengadaan::where('id_user', $id)->update(['id_user' => null]);
      Retur::where('id_user', $id)->update(['id_user' => null]);
      RiwayatAktivitas::where('id_user', $id)->update(['id_user' => null]);

      $user->delete();
      DB::commit();

      return redirect()->route('user')->with(['message' => 'Berhasil Menghapus Pengguna', 'type' => 'success']);
    } catch (Exception $e) {
      throw new Error($e);
      DB::rollBack();
      return redirect()->route('user')->with(['message' => 'Gagal Menghapus Pengguna, Silahkan coba lagi', 'type' => 'danger']);
    }
  }
}
