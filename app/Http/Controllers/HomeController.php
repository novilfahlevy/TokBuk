<?php

namespace App\Http\Controllers;

use App\Buku;
use App\Pengaturan;
use App\Transaksi;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    protected $now;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
        $this->now = Carbon::now();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $batasanStok = Pengaturan::first()->limit_stok;
        $pengguna = User::count();
        $judulBuku = Buku::count();
        $buku = (int) Buku::sum('jumlah');
        $transaksi = Transaksi::whereDate('created_at', $this->now->today()->format('Y-m-d'))->count();
        $bukuMencapaiStok = Buku::join('detail_pengadaan as dpb', 'dpb.id_buku', '=', 'buku.id')
          ->join('pengadaan as pb', 'dpb.id_pengadaan', '=', 'pb.id')
          ->select(['buku.isbn', 'buku.judul', 'buku.jumlah', DB::raw('DATE_FORMAT(MAX(pb.tanggal), "%d-%m-%Y") as tanggal')])
          ->where('buku.jumlah', '<=', $batasanStok)
          ->orderByDesc('pb.tanggal')
          ->groupBy(['buku.isbn', 'buku.judul', 'buku.jumlah'])
          ->get();
        $chartTransaksi = Transaksi::select([
            DB::raw('SUM(total_harga) AS total_perbulan'),
            DB::raw('MONTH(created_at) AS bulan')
        ])
        ->whereYear('created_at', $this->now->year)
        ->groupBy([
            DB::raw('MONTH(created_at)'),
            'bulan'
        ])
        ->orderBy('bulan')
        ->get()
        ->toArray();

        $hasil = [];

        foreach ( range(1, 12) as $bulan ) {
            $bulanAda = false;
            foreach ( $chartTransaksi as $t ) {
                if ( $t['bulan'] == $bulan ) {
                    $bulanAda = true;
                    $hasil[] = $t['total_perbulan'];
                }
            }
            if ( !$bulanAda ) $hasil[] = 0;
        }

        return view('home', compact('pengguna', 'judulBuku', 'buku', 'transaksi', 'hasil', 'bukuMencapaiStok', 'batasanStok'));
    }
}
