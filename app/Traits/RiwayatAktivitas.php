<?php

namespace App\Traits;

use App\RiwayatAktivitas as RiwayatAktivitasApp;

trait RiwayatAktivitas {
  public function rekamAktivitas($aktivitas) {
    return !!RiwayatAktivitasApp::create(compact('aktivitas'));
  }
}