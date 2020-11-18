<?php

namespace App\Http\Controllers;

use App\Retur;
use Illuminate\Http\Request;

class ReturController extends Controller
{
  public function index()
  {
    $returs = Retur::orderByDesc('tanggal')->get();
    return view('retur.index', compact('returs'));
  }
}
