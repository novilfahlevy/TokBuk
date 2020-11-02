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
    }
}
