<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Penerbit extends Model
{
    protected $table = 'penerbit';
    protected $fillable = [
        'nama'
    ];
    public function buku()
    {
        return $this->hasMany(Buku::class, 'id_penerbit');
    }
}
