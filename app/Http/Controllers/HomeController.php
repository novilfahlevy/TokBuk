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
				$chartTransaksi = Transaksi::select(db::raw('SUM(total_harga) AS total_perbulan'))
					->whereYear('created_at', $this->now->year)
					->groupBy(DB::raw('MONTH(created_at)'))
					->get()
					->map(function($transaksi) { return $transaksi->total_perbulan; })
					->toArray();
        
        return view('home', compact('pengguna', 'judulBuku', 'buku', 'transaksi', 'chartTransaksi'));
    }
}
