<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Retur extends Model
{
  protected $table = 'retur';
  protected $fillable = ['kode', 'id_pengadaan', 'id_user', 'total_dana_pengembalian', 'tanggal'];

  public function getTanggalAttribute() {
    return Carbon::parse($this->attributes['tanggal'])->format('d-m-Y');
  }

  public function pengadaan()
  {
    return $this->belongsTo(Pengadaan::class, 'id_pengadaan');
  }

  public function detail()
  {
    return $this->hasMany(DetailRetur::class, 'id_retur', 'id');
  }

  public function user()
  {
    return $this->hasOne(User::class, 'id');
  }

  protected static function boot()
  {
    parent::boot();
    static::creating(function ($query) {
      $query->id_user = auth()->id();
    });
  }
}
