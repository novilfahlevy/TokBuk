<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Distributor extends Model
{
    protected $table = 'distributor';
    protected $fillable = [
        'nama',
        'alamat',
        'email',
        'telepon'
    ];
    public function buku()
    {
        return $this->hasMany(Buku::class, 'id_distributor');
    }
}
