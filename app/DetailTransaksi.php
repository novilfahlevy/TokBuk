<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailTransaksi extends Model
{
    protected $table = 'detail_transaksi';
    protected $fillable = ['id_transaksi', 'id_buku', 'jumlah', 'harga', 'diskon'];

    public function buku()
    {
        return $this->hasOne(Buku::class, 'id', 'id_buku');
    }

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'id_transaksi', 'id');
    }
}
