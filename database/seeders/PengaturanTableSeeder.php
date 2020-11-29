<?php

namespace Database\Seeders;

use App\Pengaturan;
use Illuminate\Database\Seeder;

class PengaturanTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    Pengaturan::create([
      'nama_toko' => 'TokBuk',
      'email' => 'tokbuk@gmail.com',
      'telepon' => '089650283848',
      'alamat' => 'Jl. Langsat No. 64 Vorvo',
      'limit_stok' => 20
    ]);
  }
}
