<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Buku;
use App\DetailPengadaan;
use App\DetailTransaksi;
use App\Penulis;
use App\Penerbit;
use App\Kategori;
use App\Lokasi;
use App\Distributor;
use App\Traits\RiwayatAktivitas;
use Error;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BukuController extends Controller
{
    use RiwayatAktivitas;

    public function __construct(Buku $buku, Penulis $penulis, Distributor $distributor, Penerbit $penerbit, Kategori $kategori, Lokasi $lokasi)
    {
        $this->buku = $buku;
        $this->penulis = $penulis;
        $this->distributor = $distributor;
        $this->penerbit = $penerbit;
        $this->kategori = $kategori;
        $this->lokasi = $lokasi;
        // $this->Pengadaan = $Pengadaan;
    }
    public function index()
    {
        $buku = $this->buku->orderBy(DB::raw('CAST(jumlah as int)'))->get();
        $penulis = $this->penulis->get();
        $penerbit = $this->penerbit->get();
        $kategori = $this->kategori->get();
        $lokasi = $this->lokasi->get();
        if ( $_GET ) {
          return $this->filter(compact('penulis', 'penerbit', 'kategori', 'lokasi'));
        }

        return view('buku_admin.index', compact('buku', 'penulis', 'penerbit', 'kategori', 'lokasi'));
    }

    public function filter($data)
    {
      $buku = $this->buku->select('*');
      
      if ( $kategori = $_GET['kategori'] ) {
          $buku->where('id_kategori', $kategori);
      }

      if ( $penerbit = $_GET['penerbit'] ) {
          $buku->where('id_penerbit', $penerbit);
      }

      if ( $penulis = $_GET['penulis'] ) {
          $buku->where('id_penulis', $penulis);
      }

      if ( $lokasi = $_GET['lokasi'] ) {
          $buku->where('id_lokasi', $lokasi);
      }

      if ( $tahunTerbitDari = $_GET['tahunTerbitDari'] ) {
          $buku->where('tahun_terbit', '>=', $tahunTerbitDari);
      }
      
      if ( $tahunTerbitSampai = $_GET['tahunTerbitSampai'] ) {
          $buku->where('tahun_terbit', '<=', $tahunTerbitSampai);
      }

      if ( ($jumlahDari = $_GET['jumlahDari']) != null ) {
          $buku->where('jumlah', '>=', (int) $jumlahDari);
      }

      if ( ($jumlahSampai = $_GET['jumlahSampai']) != null ) {
          $buku->where('jumlah', '<=', (int) $jumlahSampai);
      }

      if ( isset($_GET['diskon']) ) {
          $buku->whereNotNull('diskon')->where('diskon', '>', 0);
      }

      $buku = $buku->get();
      
      session($_GET);

      $kategori = $data['kategori'];
      $penulis = $data['penulis'];
      $penerbit = $data['penerbit'];
      $lokasi = $data['lokasi'];

      return view('buku_admin.index', compact('buku', 'penulis', 'penerbit', 'kategori', 'lokasi'));
    }
    
    public function create()
    {
        $penulis = Penulis::all();
        $penerbit = Penerbit::all();
        $kategori = Kategori::all();
        $Distributor = Distributor::all();
        $lokasi = Lokasi::all();
        return view('buku_admin.create', compact('penulis', 'penerbit', 'kategori', 'Distributor', 'lokasi'));
    }

    public function edit($id)
    {
        $penulis = Penulis::all();
        $penerbit = Penerbit::all();
        $kategori = Kategori::all();
        $lokasi = Lokasi::all();
        $buku = Buku::where('id', $id)->first();

        return view('buku_admin.edit', compact('penulis', 'penerbit', 'kategori',  'buku', 'lokasi'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
          'sampul' => 'max:2048',
          'isbn' => 'required',
          'judul' => 'required'
        ]);

        $buku = Buku::where('id', $id);
        $sampulBaruRequest = $request->file('sampul');
        $namaSampulLama = $buku->first()->sampul;

        $namaSampulBaru = $this->simpanSampul($sampulBaruRequest, $namaSampulLama);

        $update = $buku->update([
          'sampul' => $sampulBaruRequest ? $namaSampulBaru : $namaSampulLama,
          'isbn' => $request->isbn,
          'judul' => $request->judul,
          'id_penulis' => $request->id_penulis ?? $buku->first()->id_penulis,
          'id_penerbit' => $request->id_penerbit ?? $buku->first()->id_penerbit,
          'id_kategori' => $request->id_kategori ?? $buku->first()->id_kategori,
          'id_lokasi' => $request->id_lokasi ?? $buku->first()->id_lokasi,
          'tahun_terbit' => $request->tahun_terbit ?? $buku->first()->tahun_terbit,
          'harga' => $request->harga ?? $buku->first()->harga,
          'diskon' => $request->diskon ?? $buku->first()->diskon
        ]);

        if($update == true) {
            $this->rekamAktivitas('Mengedit buku ' . $request->judul);
            return redirect()->route('buku.detail', ['id' => $buku->first()->id])->with(['message' => 'Berhasil Mengedit Buku', 'type' => 'success']);
        } else {
            return redirect()->route('buku')->with(['message' => 'Gagal Mengedit Buku', 'type' => 'danger']);
        }
    }

    private function simpanSampul($sampulBaruRequest, $namaSampulLama)
    {
      if ( $sampulBaru = $sampulBaruRequest ) {
        $namaSampulBaru = Str::random(20) . '.' . $sampulBaru->getClientOriginalExtension();
        if ( $sampulBaru->move(public_path('images/buku/'), $namaSampulBaru) ) {
          if ( $namaSampulLama !== 'sampul.png' ) {
            Storage::disk('public')->delete('images/buku/' . $namaSampulLama);
          }
          return $namaSampulBaru;
        }
      }
      return null;
    }

    public function detail($id)
    {
        $buku = Buku::where('id', $id)->first();
        $penulis = Penulis::where('id', $id)->first();
        $penerbit = Penerbit::where('id', $id)->first();
        $kategori = Kategori::where('id', $id)->first();
        $lokasi = Lokasi::where('id', $id)->first();
        return view('buku_admin.detail', compact('buku', 'penulis', 'penerbit', 'kategori', 'lokasi'));
    }

    public function destroy($id)
    {
      DB::beginTransaction();
      try {
        $buku = Buku::find($id);
        $judul = $buku->judul;
        $sampul = $buku->sampul;

        if ( $sampul !== 'sampul.png' ) {
          Storage::disk('public')->delete('images/buku/' . $sampul);
        }
        
        $this->rekamAktivitas('Menghapus buku ' . $judul);
        DetailTransaksi::where('id_buku', $id)->update(['id_buku' => null]);
        DetailPengadaan::where('id_buku', $id)->update(['id_buku' => null]);

        $buku->delete();
        DB::commit();

        return redirect()->route('buku')->with(['message' => 'Berhasil Menghapus Buku', 'type' => 'success']);
      } catch ( Exception $e ) {
        throw new Error($e);
        return redirect()->route('buku')->with(['message' => 'Gagal Menghapus Buku, Silahkan coba lagi', 'type' => 'danger']);
        DB::rollBack();
      }
    }
}
