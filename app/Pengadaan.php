<?php

namespace App;

// use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\DetailPengadaan;
use App\Distributor;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pengadaan extends Model
{
    protected $table = 'pengadaan';
    protected $fillable = ['kode', 'tanggal', 'id_user', 'id_distributor', 'total_harga', 'bayar', 'faktur', 'keterangan'];

    public function getTanggalAttribute() {
        return Carbon::parse($this->attributes['tanggal'])->format('d-m-Y');
    }

    public function detail()
    {
        return $this->hasMany(DetailPengadaan::class, 'id_pengadaan');
    }

    public function distributor()
    {
        return $this->hasOne(Distributor::class, 'id', 'id_distributor');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'id_user');
    }

    public function retur()
    {
        return $this->hasOne(Retur::class, 'id_pengadaan', 'id');
    }

    protected static function boot()
    {
      parent::boot();
      static::creating(function ($query) {
        $query->id_user = auth()->id();
      });
    }
}
