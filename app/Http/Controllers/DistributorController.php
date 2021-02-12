<?php

namespace App\Http\Controllers;

use App\Buku;
use Illuminate\Http\Request;
use App\Distributor;
use App\Pengadaan;
use App\RiwayatAktivitas;
use Exception;
use Illuminate\Support\Facades\DB;

class DistributorController extends Controller
{
  public function __construct(Distributor $distributor)
  {
    $this->Distributor = $distributor;
  }

  public function index()
  {
    $distributor = $this->Distributor->get();
    return view('distributor.index', compact('distributor'));
  }

  public function create()
  {
    return view('distributor.create');
  }

  public function store(Request $request)
  {
    $request->validate([
      'nama' => 'required',
      'alamat' => 'required',
      'email' => 'required',
      'telepon' => 'required'
    ]);


    $insert = Distributor::insert([
      'nama' => $request->nama,
      'alamat' => $request->alamat,
      'email' => $request->email,
      'telepon' => $request->telepon
    ]);

    if ($insert == true) {
      RiwayatAktivitas::create(['aktivitas' => 'Menambah distributor ' . $request->nama]);
      return redirect()->route('distributor')->with(['message' => 'Berhasil Menambah Distributor', 'type' => 'success']);
    } else {

      return redirect()->route('distributor')->with(['message' => 'Gagal Menambah Distributor', 'type' => 'danger']);
    }
  }

  public function edit($id)
  {
    $distributor = Distributor::where('id', $id)->first();
    return view('distributor.edit', compact('distributor'));
  }

  public function update(Request $request, $id)
  {
    $request->validate([
      'nama' => 'required',
      'alamat' => 'required',
      'email' => 'required',
      'telepon' => 'required'
    ]);

    $update = Distributor::where('id', $id)->update([
      'nama' => $request->nama,
      'alamat' => $request->alamat,
      'email' => $request->email,
      'telepon' => $request->telepon
    ]);

    if ($update == true) {
      RiwayatAktivitas::create(['aktivitas' => 'Mengedit distributor ' . $request->nama]);
      return redirect()->route('distributor')->with(['message' => 'Berhasil Mengedit Distributor', 'type' => 'success']);
    } else {
      return redirect()->route('distributor')->with(['message' => 'Gagal Mengedit Distributor', 'type' => 'danger']);
    }
  }

  public function destroy($id)
  {
    DB::beginTransaction();
    try {
      $distributor = Distributor::find($id);
      $nama = $distributor->nama;
      Pengadaan::where('id_distributor', $id)->update(['id_distributor' => null]);
      $distributor->delete();
      DB::commit();
      RiwayatAktivitas::create(['aktivitas' => 'Menghapus distributor ' . $nama]);
      return redirect()->route('distributor')->with(['message' => 'Berhasil Menghapus Distributor', 'type' => 'success']);
    } catch (Exception $e) {
      DB::rollBack();
      return redirect()->route('distributor')->with(['message' => 'Gagal Menghapus Distributor', 'type' => 'danger']);
    }
  }
}
