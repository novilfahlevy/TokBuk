<?php

use Illuminate\Database\Seeder;

class KategoriTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    App\Kategori::create([
      'nama' => 'Novel'
    ]);
    App\Kategori::create([
      'nama' => 'Komik'
    ]);
    App\Kategori::create([
      'nama' => 'Buku Ilmu Pengetahuan'
    ]);
  }
}
