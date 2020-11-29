<?php

use Database\Seeders\PengadaanTableSeeder;
use Database\Seeders\PengaturanTableSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   *
   * @return void
   */
  public function run()
  {
    $this->call(UsersTableSeeder::class);
    $this->call(PengaturanTableSeeder::class);

    if (env('APP_ENV') !== 'production') {
      $this->call(PenulisTableSeeder::class);
      $this->call(PenerbitTableSeeder::class);
      $this->call(KategoriTableSeeder::class);
      $this->call(DistributorTableSeeder::class);
      $this->call(LokasiTableSeeder::class);
      $this->call(BukuTableSeeder::class);
      $this->call(PengadaanTableSeeder::class);
    }
  }
}
