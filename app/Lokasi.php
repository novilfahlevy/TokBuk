<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lokasi extends Model
{
    protected $table = 'lokasi';
    protected $fillable = ['nama'];

    public function buku()
    {
        return $this->hasMany(Buku::class, 'id_lokasi');
    }
}
