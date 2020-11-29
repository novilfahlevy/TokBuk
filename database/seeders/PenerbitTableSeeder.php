<?php

use Illuminate\Database\Seeder;

class PenerbitTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    App\Penerbit::create([
      'nama' => 'UPP STIM YKPN'
    ]);

    App\Penerbit::create([
      'nama' => 'PT. Bukune Kreatif Cipta'
    ]);

    App\Penerbit::create([
      'nama' => 'PT Elex Media Komputindo'
    ]);

    App\Penerbit::create([
      'nama' => 'CV. ITA Surakarta'
    ]);

    App\Penerbit::create([
      'nama' => 'GagasMedia'
    ]);

    App\Penerbit::create([
      'nama' => 'PT Gramedia Jakarta'
    ]);
  }
}
