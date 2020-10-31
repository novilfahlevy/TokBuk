<?php

namespace App\Http\Controllers;

use App\Buku;
use App\Transaksi;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
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
		$transaksi = Transaksi::where(DB::raw('MONTH(created_at)'), Carbon::now()->month)->count();
        
        return view('home', compact('pengguna', 'judulBuku', 'buku', 'transaksi'));
    }
}
