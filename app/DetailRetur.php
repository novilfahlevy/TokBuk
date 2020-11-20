<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailRetur extends Model
{
  protected $table = 'detail_retur';
  protected $fillable = ['id_retur', 'id_detail_pengadaan', 'dana_pengembalian', 'jumlah', 'keterangan'];

  public function pengadaan()
  {
    return $this->belongsTo(DetailPengadaan::class, 'id_detail_pengadaan', 'id');
  }
}
