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
      'isbn' => '978-601-8520-93-1',
      'judul' => 'Janshen',
      'tahun_terbit' => 2017,
      'id_penulis' => 1,
      'id_penerbit' => 2,
      'id_kategori' => 1,
      'id_lokasi' => 1,
      'harga' => 80000,
      'jumlah' => 100,
      'barcode_1d' => '978-601-8520-93-1',
      'barcode_2d' => '978-601-8520-93-1'
    ]);

    App\Buku::create([
      'sampul' => 'sampul.png',
      'isbn' => '958-602-8121-93-3',
      'judul' => 'RPUL Edisi Terbaru',
      'tahun_terbit' => 2019,
      'id_penulis' => 3,
      'id_penerbit' => 4,
      'id_kategori' => 3,
      'id_lokasi' => 4,
      'harga' => 30000,
      'jumlah' => 100,
      'barcode_1d' => '958-602-8121-93-3',
      'barcode_2d' => '958-602-8121-93-3'
    ]);

    App\Buku::create([
      'sampul' => 'sampul.png',
      'isbn' => '921-332-8519-93-3',
      'judul' => 'Akutansi Entitas Manufaktur',
      'tahun_terbit' => 2019,
      'id_penulis' => 4,
      'id_penerbit' => 1,
      'id_kategori' => 3,
      'id_lokasi' => 4,
      'harga' => 90000,
      'jumlah' => 100,
      'barcode_1d' => '921-332-8519-93-3',
      'barcode_2d' => '921-332-8519-93-3'
    ]);

    App\Buku::create([
      'sampul' => 'sampul.png',
      'isbn' => '918-692-5419-32-3',
      'judul' => 'Doraemon Canda',
      'tahun_terbit' => 2004,
      'id_penulis' => 5,
      'id_penerbit' => 3,
      'id_kategori' => 2,
      'id_lokasi' => 3,
      'harga' => 15000,
      'jumlah' => 100,
      'barcode_1d' => '918-692-5419-32-3',
      'barcode_2d' => '918-692-5419-32-3'
    ]);

    App\Buku::create([
      'sampul' => 'sampul.png',
      'isbn' => '998-611-8329-66-3',
      'judul' => 'Rentang Kisah',
      'tahun_terbit' => 2017,
      'id_penulis' => 6,
      'id_penerbit' => 5,
      'id_kategori' => 1,
      'id_lokasi' => 1,
      'harga' => 85000,
      'jumlah' => 100,
      'barcode_1d' => '998-611-8329-66-3',
      'barcode_2d' => '998-611-8329-66-3'
    ]);

    App\Buku::create([
      'sampul' => 'sampul.png',
      'isbn' => '933-323-8898-32-4',
      'judul' => 'Danur gerbang dialog',
      'tahun_terbit' => 2015,
      'id_penulis' => 1,
      'id_penerbit' => 2,
      'id_kategori' => 1,
      'id_lokasi' => 1,
      'harga' => 90000,
      'jumlah' => 100,
      'barcode_1d' => '933-323-8898-32-4',
      'barcode_2d' => '933-323-8898-32-4'
    ]);
  }
}
