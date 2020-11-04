<?php

namespace App;

// use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\DetailPembelianBuku;
use App\Pemasok;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PembelianBuku extends Model
{
    // use HasFactory;
    use SoftDeletes;

    protected $table = 'pembelian_buku';
    protected $fillable = ['kode', 'id_user', 'id_pemasok', 'total_harga_jual', 'harga_beli', 'faktur'];

    public function detail()
    {
        return $this->hasMany(DetailPembelianBuku::class, 'id_pembelian_buku');
    }

    public function pemasok()
    {
        return $this->hasOne(Pemasok::class, 'id', 'id_pemasok');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'id_user');
    }
}
