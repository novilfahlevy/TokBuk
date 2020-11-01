<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PembelianBuku extends Model
{
    protected $table = 'pembelian_buku';
    protected $fillable = ['id_buku', 'id_user', 'harga_jual', 'harga_beli', 'jumlah', 'status'];

    
    public function buku()
    {
        return $this->belongsTo(Buku::class, 'id_buku');
    }
    
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
