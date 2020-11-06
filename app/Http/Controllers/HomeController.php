<?php

namespace App\Http\Controllers;

use App\Buku;
use App\PembelianBuku;
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
        $pengguna = User::count();
        $judulBuku = Buku::count();
        $buku = (int) Buku::sum('jumlah');
        $transaksi = Transaksi::whereDate('created_at', $this->now->today()->format('Y-m-d'))->count();
        $chartTransaksi = Transaksi::select([
            DB::raw('SUM(total_harga) AS total_perbulan'),
            DB::raw('MONTH(created_at) AS bulan')
        ])
        ->whereYear('created_at', $this->now->year)
        ->groupBy([
            DB::raw('MONTH(created_at)'),
            'bulan'
        ])
        ->get();

        $chartTransaksi = collect([1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12])
            ->map(function($bulan) use ($chartTransaksi) {
                return $chartTransaksi->map(function($transaksi) use ($bulan) {
                    return [
                        'bulan' => $transaksi->bulan == $bulan ? $transaksi->bulan : $bulan,
                        'total_perbulan' => $transaksi->bulan == $bulan ? $transaksi->total_perbulan : 0
                    ];
                });
            })
            ->map(function($transaksi) {
                return $transaksi[0]['total_perbulan'];
            });
        
        return view('home', compact('pengguna', 'judulBuku', 'buku', 'transaksi', 'chartTransaksi'));
    }
}
