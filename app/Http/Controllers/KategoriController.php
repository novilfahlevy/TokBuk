<?php

namespace App\Http\Controllers;

use App\Buku;
use Illuminate\Http\Request;
use App\Kategori;
use App\RiwayatAktivitas;
use Exception;
use Illuminate\Support\Facades\DB;

class KategoriController extends Controller
{
  public function __construct(Kategori $kategori)
  {
    $this->Kategori = $kategori;
  }

  public function index()
  {
    $kategori = $this->Kategori->get();
    return view('kategori.index', compact('kategori'));
  }

  public function store(Request $request)
  {
    $request->validate([
      'nama' => 'required'
    ]);


    $insert = Kategori::insert([
      'nama' => $request->nama
    ]);

    if ($insert == true) {
      RiwayatAktivitas::create(['aktivitas' => 'Menambah kategori ' . $request->nama]);
      return redirect()->route('kategori')->with(['message' => 'Berhasil Menambah Kategori', 'type' => 'success']);
    } else {

      return redirect()->route('kategori')->with(['message' => 'Gagal Menambah Kategori', 'type' => 'danger']);
    }
  }

  public function update(Request $request, $id)
  {
    $request->validate([
      'nama' => 'required'
    ]);

    $update = Kategori::where('id', $id)->update([
      'nama' => $request->nama
    ]);

    if ($update == true) {
      RiwayatAktivitas::create(['aktivitas' => 'Mengedit kategori ' . $request->nama]);
      return redirect()->route('kategori')->with(['message' => 'Berhasil Mengedit Kategori', 'type' => 'success']);
    } else {
      return redirect()->route('kategori')->with(['message' => 'Gagal Mengedit Kategori', 'type' => 'danger']);
    }
  }

  public function destroy($id)
  {
    DB::beginTransaction();
    try {
      $kategori = Kategori::find($id);
      $nama = $kategori->nama;
      Buku::where('id_kategori', $id)->update(['id_kategori' => null]);
      $kategori->delete();
      DB::commit();
      RiwayatAktivitas::create(['aktivitas' => 'Menghapus kategori ' . $nama]);
      return redirect()->route('kategori')->with([
        'type' => 'success',
        'message' => 'Berhasil Menghapus Kategori'
      ]);
    } catch (Exception $e) {
      DB::rollBack();
      return redirect()->route('kategori')->with([
        'type' => 'danger',
        'message' => 'Gagal Menghapus Kategori'
      ]);
    }
  }
}
