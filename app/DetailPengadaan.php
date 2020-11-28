<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailPengadaan extends Model
{
    protected $table = 'detail_pengadaan';
    protected $fillable = ['id_pengadaan', 'id_buku', 'harga', 'jumlah'];

    
    public function buku()
    {
        return $this->hasOne(Buku::class, 'id', 'id_buku');
    }
    
    public function pengadaan()
    {
        return $this->belongsTo(Pengadaan::class, 'id_pengadaan', 'id');
    }
}
