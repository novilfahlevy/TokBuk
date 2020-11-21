<?php

namespace Database\Seeders;

use App\DetailPengadaan;
use App\Pengadaan;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class PengadaanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();
        $totalHarga = ((65000 * 100) + (27000 * 100) + (84500 * 100) + (12200 * 100) + (76000 * 100) + (81300 * 100));

        Pengadaan::create([
            'kode' => 'P000001',
            'tanggal' => $now->format('Y-m-d'),
            'id_user' => 1,
            'id_distributor' => 3,
            'total_harga' => $totalHarga,
            'bayar' => $totalHarga,
            'faktur' => 'P00000000001.png',
            'keterangan' => 'Stok buku pertama.'
        ]);

        DetailPengadaan::create([
            'id_pengadaan' => 1,
            'id_buku' => 1,
            'harga' => 65000,
            'jumlah' => 100
        ]);

        DetailPengadaan::create([
            'id_pengadaan' => 1,
            'id_buku' => 2,
            'harga' => 27000,
            'jumlah' => 100
        ]);

        DetailPengadaan::create([
            'id_pengadaan' => 1,
            'id_buku' => 3,
            'harga' => 84500,
            'jumlah' => 100
        ]);

        DetailPengadaan::create([
            'id_pengadaan' => 1,
            'id_buku' => 4,
            'harga' => 12200,
            'jumlah' => 100
        ]);

        DetailPengadaan::create([
            'id_pengadaan' => 1,
            'id_buku' => 5,
            'harga' => 76000,
            'jumlah' => 100
        ]);

        DetailPengadaan::create([
            'id_pengadaan' => 1,
            'id_buku' => 6,
            'harga' => 81300,
            'jumlah' => 100
        ]);
    }
}
