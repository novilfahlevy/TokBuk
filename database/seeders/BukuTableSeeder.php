<?php

use Illuminate\Database\Seeder;

class BukuTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Buku::create([
            'sampul' => 'sampul.png',
            'isbn' => '9786022202417',
            'judul' => 'Janshen',
            'tahun_terbit' => 2015,
            'id_penulis' => 1,
            'id_penerbit' => 2,
            'id_kategori' => 3,
            'id_lokasi' => 1,
            'harga' => 80000,
            'jumlah' => 80
        ]);
        App\Buku::create([
            'sampul' => 'sampul.png',
            'isbn' => '979103504504',
            'judul' => 'RPUL',
            'tahun_terbit' => 2017,
            'id_penulis' => 2,
            'id_penerbit' => 1,
            'id_kategori' => 3,
            'id_lokasi' => 1,
            'harga' => 85000,
            'jumlah' => 76
        ]);
    }
}
