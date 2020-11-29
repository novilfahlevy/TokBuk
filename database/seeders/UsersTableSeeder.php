<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    App\User::create([
      'name' => 'owner',
      'username' => 'owner',
      'posisi' => 'Owner',
      'email' => 'owner@gmail.com',
      'telepon' => '08927621145',
      'alamat' => 'Jl. Sawo',
      'password' => bcrypt('123123')
    ]);

    App\User::create([
      'name' => 'admin',
      'username' => 'admin',
      'posisi' => 'Admin',
      'email' => 'admin@gmail.com',
      'telepon' => '085678907878',
      'alamat' => 'Jl. Bunga Bunga',
      'password' => bcrypt('123123')
    ]);

    App\User::create([
      'name' => 'operator',
      'username' => 'operator',
      'posisi' => 'Operator',
      'email' => 'operator@gmail.com',
      'telepon' => '085376563454',
      'alamat' => 'Jl. Biola',
      'password' => bcrypt('123123')
    ]);

    App\User::create([
      'name' => 'kasir',
      'username' => 'kasir',
      'posisi' => 'Kasir',
      'email' => 'kasir@gmail.com',
      'telepon' => '0852787890909',
      'alamat' => 'Jl. Pohon Cemara',
      'password' => bcrypt('123123')
    ]);

    App\User::create([
      'name' => 'Novil Fahlevy',
      'username' => 'novilfahlevy',
      'posisi' => 'Admin',
      'email' => 'novilfreon@gmail.com',
      'telepon' => '089609233200',
      'alamat' => 'Jl. Langsat',
      'password' => bcrypt('123123')
    ]);

    App\User::create([
      'name' => 'Alisanabela',
      'username' => 'icawn',
      'posisi' => 'Admin',
      'email' => 'alisanabela25@gmail.com',
      'telepon' => '085349914090',
      'alamat' => 'Jl. Damanhuri',
      'password' => bcrypt('123123')
    ]);

    App\User::create([
      'name' => 'Niken Astrid',
      'username' => 'niken',
      'posisi' => 'Admin',
      'email' => 'nikenreza@gmail.com',
      'telepon' => '085600008989',
      'alamat' => 'Jl. Sambutan',
      'password' => bcrypt('123123')
    ]);

    App\User::create([
      'name' => 'Farkhanudin',
      'username' => 'farkhan',
      'posisi' => 'Admin',
      'email' => 'farkhan@gmail.com',
      'telepon' => '085677778888',
      'alamat' => 'Jl. Merdeka',
      'password' => bcrypt('123123')
    ]);

    App\User::create([
      'name' => 'Roofi Ali',
      'username' => 'roofi',
      'posisi' => 'Admin',
      'email' => 'roofi@gmail.com',
      'telepon' => '085622223333',
      'alamat' => 'Jl. Bengkuring',
      'password' => bcrypt('123123')
    ]);

    App\User::create([
      'name' => 'Yudha Indra',
      'username' => 'yudha',
      'posisi' => 'Admin',
      'email' => 'yudha@gmail.com',
      'telepon' => '085655556666',
      'alamat' => 'Jl. Pahlawan',
      'password' => bcrypt('123123')
    ]);

    App\User::create([
      'name' => 'Fariz Dwi',
      'username' => 'fariz',
      'posisi' => 'Admin',
      'email' => 'fariz@gmail.com',
      'telepon' => '085666664444',
      'alamat' => 'Jl. Pelita',
      'password' => bcrypt('123123')
    ]);
  }
}
