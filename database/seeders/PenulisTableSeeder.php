<?php

use Illuminate\Database\Seeder;

class PenulisTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    App\Penulis::create([
      'nama' => 'Risa Saraswati'
    ]);

    App\Penulis::create([
      'nama' => 'Tere Liye'
    ]);

    App\Penulis::create([
      'nama' => 'Rahimsyah'
    ]);

    App\Penulis::create([
      'nama' => 'Dr. Martinus R. Hutauruk, S.E., M.M., Ak., CA., ACPA'
    ]);

    App\Penulis::create([
      'nama' => 'FUJIKO F. Fujio'
    ]);

    App\Penulis::create([
      'nama' => 'Gita Savitri Devi'
    ]);
  }
}
