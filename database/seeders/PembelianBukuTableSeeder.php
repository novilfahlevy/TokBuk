<?php

namespace Database\Seeders;

use App\DetailPembelianBuku;
use App\PembelianBuku;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class PembelianBukuTableSeeder extends Seeder
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

        PembelianBuku::create([
            'kode' => 'P000000001',
            'tanggal' => $now->format('Y-m-d'),
            'id_user' => 1,
            'id_distributor' => 3,
            'total_harga' => $totalHarga,
            'bayar' => $totalHarga,
            'faktur' => 'P000000001.png',
            'keterangan' => 'Stok buku pertama.'
        ]);

        DetailPembelianBuku::create([
            'id_pembelian' => 1,
            'id_buku' => 1,
            'status' => 'Baru',
            'harga' => 65000,
            'jumlah' => 100
        ]);

        DetailPembelianBuku::create([
            'id_pembelian' => 1,
            'id_buku' => 2,
            'status' => 'Baru',
            'harga' => 27000,
            'jumlah' => 100
        ]);

        DetailPembelianBuku::create([
            'id_pembelian' => 1,
            'id_buku' => 3,
            'status' => 'Baru',
            'harga' => 84500,
            'jumlah' => 100
        ]);

        DetailPembelianBuku::create([
            'id_pembelian' => 1,
            'id_buku' => 4,
            'status' => 'Baru',
            'harga' => 12200,
            'jumlah' => 100
        ]);

        DetailPembelianBuku::create([
            'id_pembelian' => 1,
            'id_buku' => 5,
            'status' => 'Baru',
            'harga' => 76000,
            'jumlah' => 100
        ]);

        DetailPembelianBuku::create([
            'id_pembelian' => 1,
            'id_buku' => 6,
            'status' => 'Baru',
            'harga' => 81300,
            'jumlah' => 100
        ]);
    }
}
