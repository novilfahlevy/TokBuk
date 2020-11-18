<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Retur extends Model
{
  protected $table = 'retur';
  protected $fillable = ['kode', 'id_pengadaan', 'total_data_pengembalian', 'tanggal'];
}
