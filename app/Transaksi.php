<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaksi extends Model
{
  protected $table = 'transaksi';
  protected $fillable = ['kode', 'id_user', 'bayar', 'total_harga'];

  public function user()
  {
    return $this->hasOne(User::class, 'id', 'id_user');
  }

  public function detail()
  {
    return $this->hasMany(DetailTransaksi::class, 'id_transaksi');
  }

  protected static function boot()
  {
    parent::boot();
    static::creating(function ($query) {
      $query->id_user = auth()->id();
    });
  }
}
