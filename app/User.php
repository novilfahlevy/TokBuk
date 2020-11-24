<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 
        'username', 
        'posisi',
        'email',
        'telepon', 
        'alamat', 
        'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function transaksi()
    {
      return $this->hasMany(Transaksi::class, 'id_user');
    }

    public function pengadaan()
    {
      return $this->hasMany(Pengadaan::class, 'id_user');
    }

    public function retur()
    {
      return $this->hasMany(Retur::class, 'id_user');
    }

    public function aktivitas()
    {
      return $this->hasMany(RiwayatAktivitas::class, 'id_user');
    }
}
