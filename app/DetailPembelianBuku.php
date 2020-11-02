<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailPembelianBuku extends Model
{
    protected $table = 'detail_pembelian_buku';
    protected $fillable = ['id_pembelian_buku', 'id_buku', 'harga_jual', 'jumlah', 'status'];

    
    public function buku()
    {
        return $this->hasOne(Buku::class, 'id_buku');
    }
    
    public function pembelian()
    {
        return $this->belongsTo(User::class, 'id_pembelian_buku');
    }
}
