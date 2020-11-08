<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaksi extends Model
{
    use SoftDeletes;

    protected $table = 'transaksi';
    protected $fillable = ['kode', 'id_user', 'bayar', 'total_harga', 'keterangan', 'diskon'];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'id_user');
    }

    public function detail()
    {
        return $this->hasMany(DetailTransaksi::class, 'id_transaksi');
    }
}
