<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pemasok extends Model
{
    protected $table = 'pemasok';
    protected $fillable = [
        'nama',
        'alamat',
        'email',
        'telepon'
    ];
    public function buku()
    {
        return $this->hasMany(Buku::class, 'id_pemasok');
    }
}
