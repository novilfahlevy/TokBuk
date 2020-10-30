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
            'nama' => 'Lee Dae Han'
        ]);
    }
}
