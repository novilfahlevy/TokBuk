<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Buku extends Model
{
    protected $table = 'buku';
    protected $fillable = [
        'sampul',
        'isbn',
        'judul',
        'tahun_terbit',
        'id_penulis',
        'id_penerbit',
        'id_kategori',
        // 'id_distributor',
        'id_lokasi',
        'harga',
        'jumlah'
    ];

    public function penulis()
    {
        return $this->belongsTo(Penulis::class, 'id_penulis');
    }

    public function penerbit()
    {
        return $this->belongsTo(Penerbit::class, 'id_penerbit');
    }

    public function Kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }

    // public function Distributor()
    // {
    //     return $this->belongsTo(Distributor::class, 'id_distributor');
    // }

    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class, 'id_lokasi');
    }

    public function pembelian()
    {
        return $this->hasMany(DetailPengadaan::class, 'id_buku');
    }
}
