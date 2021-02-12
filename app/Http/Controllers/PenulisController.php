<?php

namespace App\Http\Controllers;

use App\Buku;
use Illuminate\Http\Request;
use App\Penulis;
use App\RiwayatAktivitas;
use Error;
use Exception;
use Illuminate\Support\Facades\DB;

class PenulisController extends Controller
{
  public function __construct(Penulis $penulis)
  {
    $this->penulis = $penulis;
  }
  public function index()
  {
    $penulis = $this->penulis->get();
    return view('penulis.index', compact('penulis'));
  }

  public function store(Request $request)
  {
    $request->validate([
      'nama' => 'required'
    ]);


    $insert = Penulis::insert([
      'nama' => $request->nama
    ]);

    if ($insert == true) {
      RiwayatAktivitas::create(['aktivitas' => 'Menambah penulis ' . $request->nama]);
      return redirect()->route('penulis')->with(['message' => 'Berhasil Menambah Penulis', 'type' => 'success']);
    } else {

      return redirect()->route('penulis')->with(['message' => 'Gagal Menambah Penulis', 'type' => 'danger']);
    }
  }


  public function update(Request $request, $id)
  {
    $request->validate([
      'nama' => 'required'
    ]);

    $update = Penulis::where('id', $id)->update([
      'nama' => $request->nama
    ]);

    if ($update == true) {
      RiwayatAktivitas::create(['aktivitas' => 'Mengedit penulis ' . $request->nama]);
      return redirect()->route('penulis')->with(['message' => 'Berhasil Mengedit Penulis', 'type' => 'success']);
    } else {
      return redirect()->route('penulis')->with(['message' => 'Gagal Mengedit Penulis', 'type' => 'danger']);
    }
  }

  public function destroy($id)
  {
    DB::beginTransaction();
    try {
      $penulis = Penulis::find($id);
      $nama = $penulis->nama;
      Buku::where('id_penulis', $id)->update(['id_penulis' => null]);
      $penulis->delete();
      DB::commit();
      RiwayatAktivitas::create(['aktivitas' => 'Menghapus penulis ' . $nama]);
      return redirect()->route('penulis')->with([
        'type' => 'success',
        'message' => 'Berhasil Menghapus Penulis'
      ]);
    } catch (Exception $e) {
      throw new Error($e);
      DB::rollBack();
      return redirect()->route('penulis')->with([
        'type' => 'danger',
        'message' => 'Gagal Menghapus Penulis'
      ]);
    }
  }
}
