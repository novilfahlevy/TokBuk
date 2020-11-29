<?php

use Illuminate\Database\Seeder;

class LokasiTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    for ($lokasi = 1; $lokasi <= 8; $lokasi++) {
      App\Lokasi::create([
        'nama' => 'Rak ' . $lokasi
      ]);
    }
  }
}
