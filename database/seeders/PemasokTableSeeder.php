<?php

use Illuminate\Database\Seeder;

class PemasokTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Pemasok::create([
            'nama' => 'Ahmad',
            'alamat' => 'Jl. Anggrek No.08',
            'email' => 'ahmad@gmail.com',
            'telepon' => '085689785678'
        ]);
        App\Pemasok::create([
            'nama' => 'Dimas',
            'alamat' => 'Jl. Melati No.09',
            'email' => 'dimas@gmail.com',
            'telepon' => '089678998899'
        ]);
        App\Pemasok::create([
            'nama' => 'Rara',
            'alamat' => 'Jl. Kenanga No.11',
            'email' => 'rara@gmail.com',
            'telepon' => '084567896767'
        ]);
    }
}
