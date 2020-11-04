<?php

namespace App\Http\Controllers;

use App\Buku;
use App\PembelianBuku;
use App\Transaksi;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
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
		$transaksi = Transaksi::where(DB::raw('MONTH(created_at)'), $this->now->month)->count();
        
        return view('home', compact('pengguna', 'judulBuku', 'buku', 'transaksi'));
    }

    public function chart(Request $request)
    {
        $label = collect(range(1, $this->now->daysInMonth))->map(function($day) {
            return 'Hari ke-' . $day;
        });

        $pendapatan = Transaksi::where(DB::raw('MONTH(created_at)'), $request->bulan ?? $this->now->month)
            ->where(DB::raw('YEAR(created_at)'), $request->tahun ?? $this->now->year)
            ->select(DB::raw('SUM(total_harga) AS total_harga'))
            ->groupBy(DB::raw('DATE(created_at)'))
            ->get();

        // $pengeluaran = PembelianBuku::where(DB::raw('MONTH(created_at)'), $this->now->month)
        //     ->select(DB::raw('SUM(harga * jumlah) AS total_harga'))
        //     ->groupBy(DB::raw('DATE(created_at)'))
        //     ->get();

        $waktuMasukan = Carbon::parse(
            ($request->tahun ?? $this->now->year) . '-' . ($request->bulan ?? $this->now->month)
        );

        return response()->json([
            'status' => 200,
            'data' => [
                'bulan' => $waktuMasukan->monthName,
                'tahun' => $waktuMasukan->year,
                'label' => $label,
                'pendapatan' => $pendapatan,
                'pengeluaran' => []
                // 'pengeluaran' => $pengeluaran
            ]
        ]);
    }
}
