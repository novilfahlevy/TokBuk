<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Retur extends Model
{
  protected $table = 'retur';
  protected $fillable = ['kode', 'id_pengadaan', 'id_user', 'total_data_pengembalian', 'tanggal'];

  public function getTanggalAttribute() {
    return Carbon::parse($this->attributes['tanggal'])->format('d-m-Y');
  }

  public function pengadaan()
  {
    return $this->belongsTo(Pengadaan::class, 'id_pengadaan');
  }
}
