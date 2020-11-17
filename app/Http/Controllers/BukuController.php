<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Buku;
use App\Events\UpdateDasborEvent;
use App\Exports\PembelianBukuExport;
use App\Penulis;
use App\Penerbit;
use App\Kategori;
// use App\Distributor;
use App\Lokasi;
use App\Distributor;
use App\PembelianBuku;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class BukuController extends Controller
{
    public function __construct(Buku $buku, Penulis $penulis, Distributor $distributor, Penerbit $penerbit, Kategori $kategori, Lokasi $lokasi)
    {
        $this->buku = $buku;
        $this->penulis = $penulis;
        $this->distributor = $distributor;
        $this->penerbit = $penerbit;
        $this->kategori = $kategori;
        $this->lokasi = $lokasi;
        // $this->pembelianbuku = $pembelianbuku;
    }
    public function index()
    {
        $buku = $this->buku->orderBy(DB::raw('CAST(jumlah as int)'))->get();
        $penulis = $this->penulis->get();
        $penerbit = $this->penerbit->get();
        $kategori = $this->kategori->get();
        $lokasi = $this->lokasi->get();

        return view('buku_admin.index', compact('buku', 'penulis', 'penerbit', 'kategori', 'lokasi'));
    }

    public function filter(Request $request)
	{
		$buku = Buku::select('*');
        $penulis = $this->penulis->get();
        $distributor = $this->distributor->get();
        $penerbit = $this->penerbit->get();
        $kategori = $this->kategori->get();
        $lokasi = $this->lokasi->get();
		
        if ( $request->kategori ) {
            $buku->where('id_kategori', $request->kategori);
        }

        if ( $request->penerbit ) {
            $buku->where('id_penerbit', $request->penerbit);
        }

        if ( $request->penulis ) {
            $buku->where('id_penulis', $request->penulis);
        }

        if ( $request->distributor ) {
            $buku->where('id_distributor', $request->distributor);
        }

        if ( $request->lokasi ) {
            $buku->where('id_lokasi', $request->lokasi);
        }

        if ( $request->tahunTerbitDari ) {
            $buku->where('tahun_terbit', '>=', $request->tahunTerbitDari);
        }
        
        if ( $request->tahunTerbitSampai ) {
            $buku->where('tahun_terbit', '<=', $request->tahunTerbitSampai);
        }

        if ( $request->jumlahDari !== null ) {
            $buku->where('jumlah', '>=', (int) $request->jumlahDari);
        }

        if ( $request->jumlahSampai !== null ) {
            $buku->where('jumlah', '<=', (int) $request->jumlahSampai);
        }

        if ( $request->diskon ) {
            $buku->whereNotNull('diskon')->where('diskon', '>', 0);
        }

        $buku = $buku->get();
        
        session($request->except('_token'));

		return view('buku_admin.index', compact('buku', 'penulis', 'penerbit', 'kategori', 'lokasi', 'distributor'));
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
        $validate = $request->validate([
            'sampul' => 'max:2048',
            'isbn' => 'required',
            'judul' => 'required',
            // 'id_penulis' => 'required',
            // 'id_penerbit' => 'required',
            // 'id_kategori' => 'required',
            // 'id_lokasi' => 'required',
            // 'tahun_terbit' => 'required',
            // 'harga' => 'required'
        ]);

        $buku = Buku::where('id', $id);

        if ( $request->sampul ) {
            $sampulLama = $buku->first()->sampul;
            $sampulBaru = $request->file('sampul');
            $namaBaru = Str::random(20) . '.' . $sampulBaru->getClientOriginalExtension();
            
            if ( $sampulLama !== 'sampul.png' ) {
                Storage::disk('public')->delete('images/buku/' . $sampulLama);
            }

            $sampulBaru->move(public_path('images/buku/'), $namaBaru);
          }

          $update = $buku->update([
            'sampul' => $request->sampul ? $namaBaru : $buku->first()->sampul,
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
            return redirect()->route('buku.detail', ['id' => $buku->first()->id])->with(['message' => 'Berhasil Mengedit Buku', 'type' => 'success']);
        } else {
            return redirect()->route('buku')->with(['message' => 'Gagal Mengedit Buku', 'type' => 'danger']);
        }
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
        $buku = Buku::find($id);
        $sampul = $buku->sampul;
        if ( $buku->delete() ) {
            if ( $sampul !== 'sampul.png' ) {
                Storage::disk('public')->delete('images/buku/' . $sampul);
            }
            return redirect()->route('buku')->with(['message' => 'Berhasil Menghapus Buku', 'type' => 'success']);
        }
        return redirect()->route('buku')->with(['message' => 'Gagal Menghapus Buku, Silahkan coba lagi', 'type' => 'danger']);
    }
}
