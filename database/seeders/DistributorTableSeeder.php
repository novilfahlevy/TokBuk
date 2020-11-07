<?php

use Illuminate\Database\Seeder;

class DistributorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Distributor::create([
            'nama' => 'Sukses Sejahtera',
            'alamat' => 'Jl. Anggrek No.08',
            'email' => 'suksessejahtera@gmail.com',
            'telepon' => '085689785678'
        ]);

        App\Distributor::create([
            'nama' => 'Alam Sejahtera',
            'alamat' => 'Jl. Melati No.09',
            'email' => 'Alamsejahtera@gmail.com',
            'telepon' => '089678998899'
        ]);

        App\Distributor::create([
            'nama' => 'Sinar Kemboja',
            'alamat' => 'Jl. Kenanga No.11',
            'email' => 'sinark@gmail.com',
            'telepon' => '084567896767'
        ]);

        App\Distributor::create([
            'nama' => 'Aktiva Makmur',
            'alamat' => 'Jl. Cempaka No.14',
            'email' => 'aktivamakmur@gmail.com',
            'telepon' => '084578785656'
        ]);

        App\Distributor::create([
            'nama' => 'Tuan Agung',
            'alamat' => 'Jl. Kamboja No.67',
            'email' => 'tuanagung@gmail.com',
            'telepon' => '08457856454545'
        ]);

        App\Distributor::create([
            'nama' => 'Adhiguna Mandiri',
            'alamat' => 'Jl. Pahlawan No.1',
            'email' => 'adhigunaman@gmail.com',
            'telepon' => '085245456767'
        ]);


    }
}
