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
// use App\Pemasok;
use App\Lokasi;
use App\Pemasok;
use App\PembelianBuku;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class BukuController extends Controller
{
    public function __construct(Buku $buku, Penulis $penulis, Pemasok $pemasok, Penerbit $penerbit, Kategori $kategori, Lokasi $lokasi)
    {
        $this->buku = $buku;
        $this->penulis = $penulis;
        $this->pemasok = $pemasok;
        $this->penerbit = $penerbit;
        $this->kategori = $kategori;
        $this->lokasi = $lokasi;
        // $this->pembelianbuku = $pembelianbuku;
    }
    public function index()
    {
        $buku = $this->buku->get();
        $penulis = $this->penulis->get();
        $pemasok = $this->pemasok->get();
        $penerbit = $this->penerbit->get();
        $kategori = $this->kategori->get();
        $lokasi = $this->lokasi->get();

        return view('buku_admin.index', compact('buku', 'penulis', 'penerbit', 'kategori', 'lokasi', 'pemasok'));
    }

    public function filter(Request $request)
	{
		$buku = Buku::select('*');
        $penulis = $this->penulis->get();
        $pemasok = $this->pemasok->get();
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

        if ( $request->pemasok ) {
            $buku->where('id_pemasok', $request->pemasok);
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

        $buku = $buku->get();
        
        session($request->except('_token'));

		return view('buku_admin.index', compact('buku', 'penulis', 'penerbit', 'kategori', 'lokasi', 'pemasok'));
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
        // $pembelianbuku = PembelianBuku::create([
        //     'id_buku' => $buku->id,
        //     'id_user' => auth()->user()->id,
        //     'harga_jual' => $request->harga_jual,
        //     'harga_beli' => $request->harga_beli,
        //     'jumlah' => $request->jumlah,
        //     'status' => 'Baru'
        // ]);

       

        if($buku == true ){
            event(new UpdateDasborEvent());
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
            'id_penulis' => 'required',
            'id_penerbit' => 'required',
            'id_kategori' => 'required',
            'id_lokasi' => 'required',
            'tahun_terbit' => 'required',
            'harga' => 'required'
        ]);

        $buku = Buku::where('id', $id);

        if ( $request->sampul ) {
            $sampulLama = $buku->first()->sampul;
            $sampul = $request->file('sampul');
            $get_name = explode('.', $sampulLama)[0] . '.' . $sampul->getClientOriginalExtension();
            Storage::disk('public')->delete('images/buku/' . $sampulLama);
            $sampul->move(public_path('images/buku/'), $get_name);
          }

          $update = $buku->update([
            'sampul' => $request->sampul ? $get_name : $buku->first()->sampul,
            'isbn' => $request->isbn,
            'judul' => $request->judul,
            'id_penulis' => $request->id_penulis,
            'id_penerbit' => $request->id_penerbit,
            'id_kategori' => $request->id_kategori,
            'id_lokasi' => $request->id_lokasi,
            'tahun_terbit' => $request->tahun_terbit,
            'harga' => $request->harga

        ]);

        if($update == true) {
            return redirect()->route('buku')->with(['message' => 'Berhasil Mengedit Buku', 'type' => 'success']);
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

    // public function logs()
    // {
    //     $logs = PembelianBuku::orderBy('created_at', 'DESC')->get();
    //     return view('buku_admin.logs', compact('logs'));
    // }

    // public function tambahjml($id)
    // {
    //     $buku = Buku::where('id', $id)->first();
    //     return view('buku_admin.tambahjumlah', compact('buku'));
    // }

    // public function tambahstore(Request $request, $id)
    // {
    //     $validate = $request->validate([
    //         'harga_jual' => 'required',
    //         'harga_beli' => 'required',
    //         'jumlah' => 'required'
    //     ]);
        
    //     DB::beginTransaction();

    //     try {
    //         $buku = Buku::where('id', $id);
            
    //         $logb = PembelianBuku::create([
    //             'id_buku' => $buku->first()->id,
    //             'id_user' => auth()->user()->id,
    //             'harga_beli' => $request->harga_beli,
    //             'harga_jual' => $request->harga_jual,
    //             'jumlah' => $request->jumlah,
    //             'status' => 'Penambahan'
    //         ]);

    //         $buku->update([
    //             'jumlah' => $buku->first()->jumlah + $request->jumlah
    //         ]);

    //         DB::commit();

    //         event(new UpdateDasborEvent());

    //         return redirect()->route('buku')->with(['message' => 'Berhasil Menambah Jumlah Buku', 'type' => 'success']);
    //     } catch ( Exception $e ) {
    //         DB::rollBack();
    //         return redirect()->route('buku.tambahstore')->with(['message' => 'Gagal Menambah Jumlah Buku', 'type' => 'danger']);
    //     }
    // }

    // public function export(Request $request)
    // {
    //     return Excel::download(new PembelianBukuExport($request->mulai, $request->sampai), 'pembelian-buku.xlsx');
    // }
}
