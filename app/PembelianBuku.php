<?php

namespace App;

// use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\DetailPembelianBuku;
use App\Pemasok;
use App\User;
use Illuminate\Database\Eloquent\Model;

class PembelianBuku extends Model
{
    // use HasFactory;

    protected $table = 'pembelian_buku';
    protected $fillable = ['tanggal', 'id_user', 'id_pemasok', 'total_harga_jual', 'harga_beli'];

    public function detail()
    {
        return $this->hasMany(DetailPembelianBuku::class, 'id_pembelian_buku');
    }

    public function pemasok()
    {
        return $this->hasOne(Pemasok::class, 'id_pemasok');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id_user');
    }
}
