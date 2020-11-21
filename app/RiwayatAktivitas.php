<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RiwayatAktivitas extends Model
{
  protected $table = 'riwayat_aktivitas';
  protected $fillable = ['id_user', 'aktivitas'];

  protected static function boot()
  {
    parent::boot();
    static::creating(function ($query) {
      $query->id_user = auth()->id();
    });
  }

  public function user()
  {
    return $this->hasOne(User::class, 'id', 'id_user');
  }
}
