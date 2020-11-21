<?php

namespace App\Http\Controllers;

use App\RiwayatAktivitas;
use Illuminate\Http\Request;

class RiwayatAktivitasController extends Controller
{
  public function index()
  {
    $riwayat = RiwayatAktivitas::orderByDesc('created_at')->get();
    return view('aktivitas.index', compact('riwayat'));
  }
}
