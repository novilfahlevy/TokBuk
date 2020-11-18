<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailRetur extends Model
{
  protected $table = 'detail_retur';
  protected $fillable = ['id_retur', 'id_detail_pengadaan', 'data_pengembalian', 'jumlah'];
}
