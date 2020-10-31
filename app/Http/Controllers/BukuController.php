<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Buku;
use App\Penulis;
use App\Penerbit;
use App\Kategori;
use App\Pemasok;
use App\Lokasi;
use App\LogBuku;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class BukuController extends Controller
{
    public function __construct(Buku $buku, Penulis $penulis, Penerbit $penerbit, Kategori $kategori, Pemasok $Pemasok, Lokasi $lokasi, LogBuku $logbuku)
    {
        $this->buku = $buku;
        $this->penulis = $penulis;
        $this->penerbit = $penerbit;
        $this->kategori = $kategori;
        $this->lokasi = $lokasi;
        $this->logbuku = $logbuku;
    }
    public function index()
    {
        $buku = $this->buku->get();
        $penulis = $this->buku->get();
        return view('buku_admin.index', compact('buku', 'penulis'));
    }
    
    public function create()
    {
        $penulis = Penulis::all();
        $penerbit = Penerbit::all();
        $kategori = Kategori::all();
        $Pemasok = Pemasok::all();
        $lokasi = Lokasi::all();
        return view('buku_admin.create', compact('penulis', 'penerbit', 'kategori', 'Pemasok', 'lokasi'));
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'sampul' => 'required|mimes:png,jpg,jpeg|max:2048',
            'isbn' => 'required',
            'judul' => 'required',
            'tahun_terbit' => 'required',
            'id_penulis' => 'required',
            'id_penerbit' => 'required', 
            'id_kategori' => 'required',
            'id_pemasok' => 'required',
            'id_lokasi' => 'required',
            'harga' => 'required',
            'harga_jual' => 'required',
            'harga_beli' => 'required',
            'jumlah' => 'required'

        ]);
        
        $sampul = $request->file('sampul');
        $get_name = Str::random(32) . '.' . $sampul->getClientOriginalExtension();
        $sampul->move(public_path('images/buku/'), $get_name);

        $buku = Buku::create([
            'sampul' => $get_name,
            'isbn' => $request->isbn,
            'judul' => $request->judul,
            'tahun_terbit' => $request->tahun_terbit,
            'id_penulis' => $request->id_penulis,
            'id_penerbit' => $request->id_penerbit,
            'id_kategori' => $request->id_kategori,
            'id_pemasok' => $request->id_pemasok,
            'id_lokasi' => $request->id_lokasi,
            'harga' => $request->harga,
            'jumlah' => $request->jumlah,

            
        ]);
        $logbuku = LogBuku::create([
            'id_buku' => $buku->id,
            'id_user' => auth()->user()->id,
            'harga_jual' => $request->harga_jual,
            'harga_beli' => $request->harga_beli,
            'jumlah' => $request->jumlah,
            'status' => 'Baru'
        ]);

       

        if($buku == true ){
            return redirect()->route('buku')->with(['message' => 'Berhasil Menambah Buku', 'type' => 'success']);
        } else {
            return redirect()->route('buku')->with(['message' => 'Gagal Menambah Buku', 'type' => 'danger']);
        }
    }

    public function edit($id)
    {
        $penulis = Penulis::all();
        $penerbit = Penerbit::all();
        $kategori = Kategori::all();
        $Pemasok = Pemasok::all();
        $lokasi = Lokasi::all();
        $buku = Buku::where('id', $id)->first();

        return view('buku_admin.edit', compact('penulis', 'penerbit', 'kategori', 'Pemasok', 'buku', 'lokasi'));
    }

    public function update(Request $request, $id)
    {
        $validate = $request->validate([
            'sampul' => 'max:2048',
            'isbn' => 'required',
            'judul' => 'required',
            'id_penulis' => 'required',
            'id_penerbit' => 'required',
            'id_kategori' => 'required',
            'id_pemasok' => 'required',
            'id_lokasi' => 'required',
            'tahun_terbit' => 'required',
            'harga' => 'required'
        ]);

        $buku = Buku::where('id', $id);

        if ( $request->sampul ) {
            $sampulLama = $buku->first()->sampul;
            $sampul = $request->file('sampul');
            $get_name = explode('.', $sampulLama)[0] . '.' . $sampul->getClientOriginalExtension();
            $sampul->move(public_path('images/buku/'), $get_name);
            Storage::disk('public')->delete('images/buku/' . $sampulLama);
          }

          $update = $buku->update([
            'sampul' => $request->sampul ? $get_name : $buku->first()->sampul,
            'isbn' => $request->isbn,
            'judul' => $request->judul,
            'id_penulis' => $request->id_penulis,
            'id_penerbit' => $request->id_penerbit,
            'id_kategori' => $request->id_kategori,
            'id_pemasok' => $request->id_pemasok,
            'id_lokasi' => $request->id_lokasi,
            'tahun_terbit' => $request->tahun_terbit,
            'harga' => $request->harga

        ]);

        if($update == true) {
            return redirect()->route('buku')->with(['message' => 'Berhasil Mengubah Data Buku', 'type' => 'success']);
        } else {
            return redirect()->route('buku')->with(['message' => 'Gagal Mengubah Data Buku', 'type' => 'danger']);
        }
    }

    public function detail($id)
    {
        $buku = Buku::where('id', $id)->first();
        $penulis = Penulis::where('id', $id)->first();
        $penerbit = Penerbit::where('id', $id)->first();
        $kategori = Kategori::where('id', $id)->first();
        $Pemasok = Pemasok::where('id', $id)->first();
        $lokasi = Lokasi::where('id', $id)->first();
        return view('buku_admin.detail', compact('buku', 'penulis', 'penerbit', 'kategori', 'Pemasok', 'lokasi'));
    }

    public function destroy($id)
    {
        $buku = Buku::find($id);
        $sampul = $buku->sampul;
        if ( $buku->delete() ) {
            Storage::disk('public')->delete('images/buku/' . $sampul);
            return redirect()->route('buku')->with(['message' => 'Berhasil Menghapus Data Buku', 'type' => 'success']);
        }
        return redirect()->route('buku')->with(['message' => 'Gagal Menghapus Data Buku, Silahkan coba lagi', 'type' => 'danger']);
    }

    public function logs()
    {
        $logs = LogBuku::orderBy('created_at', 'DESC')->get();
        return view('buku_admin.logs', compact('logs'));
    }

    public function tambahjml($id)
    {
        $buku = Buku::where('id', $id)->first();
        return view('buku_admin.tambahjumlah', compact('buku'));
    }

    public function tambahstore(Request $request, $id)
    {
        $validate = $request->validate([
            'harga_jual' => 'required',
            'harga_beli' => 'required',
            'jumlah' => 'required'
        ]);
        
        DB::beginTransaction();

        try {
            $buku = Buku::where('id', $id);
            
            $logb = LogBuku::create([
                'id_buku' => $buku->first()->id,
                'id_user' => auth()->user()->id,
                'harga_beli' => $request->harga_beli,
                'harga_jual' => $request->harga_jual,
                'jumlah' => $request->jumlah,
                'status' => 'Penambahan'
            ]);

            $buku->update([
                'jumlah' => $buku->first()->jumlah + $request->jumlah
            ]);

            DB::commit();

            return redirect()->route('buku')->with(['message' => 'Berhasil Menambah Jumlah Buku', 'type' => 'success']);
        } catch ( Exception $e ) {
            DB::rollBack();
            return redirect()->route('buku.tambahstore')->with(['message' => 'Gagal Menambah Jumlah Buku, Silahkan coba lagi', 'type' => 'danger']);
        }
    }
}
