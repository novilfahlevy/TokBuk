<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LogBuku extends Model
{
    protected $table = 'log_buku';
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
