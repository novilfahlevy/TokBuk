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
            'tahun_terbit' => 2017,
            'id_penulis' => 1,
            'id_penerbit' => 2,
            'id_kategori' => 1,
            'id_lokasi' => 1,
            'harga' => 80000,
            'jumlah' => 30
        ]);

        App\Buku::create([
            'sampul' => 'sampul.png',
            'isbn' => '979103504504',
            'judul' => 'RPUL Edisi Terbaru',
            'tahun_terbit' => 2019,
            'id_penulis' => 3,
            'id_penerbit' => 4,
            'id_kategori' => 3,
            'id_lokasi' => 4,
            'harga' => 30000,
            'jumlah' => 35
        ]);

        App\Buku::create([
            'sampul' => 'sampul.png',
            'isbn' => '9786021286746',
            'judul' => 'Akutansi Entitas Manufaktur',
            'tahun_terbit' => 2019,
            'id_penulis' => 4,
            'id_penerbit' => 1,
            'id_kategori' => 3,
            'id_lokasi' => 4,
            'harga' => 90000,
            'jumlah' => 40
        ]);

        App\Buku::create([
            'sampul' => 'sampul.png',
            'isbn' => '9792056440',
            'judul' => 'Doraemon Canda',
            'tahun_terbit' => 2004,
            'id_penulis' => 5,
            'id_penerbit' => 3,
            'id_kategori' => 2,
            'id_lokasi' => 3,
            'harga' => 15000,
            'jumlah' => 35
        ]);

        App\Buku::create([
            'sampul' => 'sampul.png',
            'isbn' => '9789797809034',
            'judul' => 'Rentang Kisah',
            'tahun_terbit' => 2017,
            'id_penulis' => 6,
            'id_penerbit' => 5,
            'id_kategori' => 1,
            'id_lokasi' => 1,
            'harga' => 85000,
            'jumlah' => 30
        ]);

        App\Buku::create([
            'sampul' => 'sampul.png',
            'isbn' => '9786022201502',
            'judul' => 'Danur gerbang dialog',
            'tahun_terbit' => 2015,
            'id_penulis' => 1,
            'id_penerbit' => 2,
            'id_kategori' => 1,
            'id_lokasi' => 1,
            'harga' => 90000,
            'jumlah' => 20
        ]);

        
    }
}
