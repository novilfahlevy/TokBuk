<?php

namespace App\Http\Controllers;

use App\Buku;
use Illuminate\Http\Request;
use App\Penerbit;
use App\RiwayatAktivitas;
use Exception;
use Illuminate\Support\Facades\DB;

class PenerbitController extends Controller
{
  public function __construct(Penerbit $penerbit)
  {
    $this->penerbit = $penerbit;
  }
  public function index()
  {
    $penerbit = $this->penerbit->get();
    return view('penerbit.index', compact('penerbit'));
  }

  public function create()
  {
    return view('penerbit.create');
  }

  public function store(Request $request)
  {
    $request->validate([
      'nama' => 'required'
    ]);


    $insert = Penerbit::insert([
      'nama' => $request->nama,
      'alamat' => $request->alamat ?? '',
      'telepon' => $request->telepon ?? '',
      'email' => $request->email ?? ''
    ]);

    if ($insert == true) {
      RiwayatAktivitas::create(['aktivitas' => 'Menambah penerbit ' . $request->nama]);
      return redirect()->route('penerbit')->with(['message' => 'Berhasil Menambah Penerbit', 'type' => 'success']);
    } else {

      return redirect()->route('penerbit')->with(['message' => 'Gagal Menambah Penerbit', 'type' => 'danger']);
    }
  }

  public function edit($id)
  {
    $penerbit = Penerbit::where('id', $id)->first();
    return view('penerbit.edit', compact('penerbit'));
  }

  public function update(Request $request, $id)
  {
    $request->validate([
      'nama' => 'required'
    ]);

    $update = Penerbit::where('id', $id)->update([
      'nama' => $request->nama,
      'alamat' => $request->alamat ?? '',
      'telepon' => $request->telepon ?? '',
      'email' => $request->email ?? ''
    ]);

    if ($update == true) {
      RiwayatAktivitas::create(['aktivitas' => 'Mengedit penerbit ' . $request->nama]);
      return redirect()->route('penerbit')->with(['message' => 'Berhasil Mengedit Penerbit', 'type' => 'success']);
    } else {
      return redirect()->route('penerbit')->with(['message' => 'Gagal Mengedit Penerbit', 'type' => 'danger']);
    }
  }

  public function destroy($id)
  {
    DB::beginTransaction();
    try {
      $penerbit = Penerbit::find($id);
      $nama = $penerbit->nama;
      Buku::where('id_penerbit', $id)->update(['id_penerbit' => null]);
      $penerbit->delete();
      DB::commit();
      RiwayatAktivitas::create(['aktivitas' => 'Menghapus penerbit ' . $nama]);
      return redirect()->route('penerbit')->with(['message' => 'Berhasil Menghapus Penerbit', 'type' => 'success']);
    } catch (Exception $e) {
      DB::rollBack();
      return redirect()->route('penerbit')->with(['message' => 'gagal Menghapus Penerbit', 'type' => 'danger']);
    }
  }
}
