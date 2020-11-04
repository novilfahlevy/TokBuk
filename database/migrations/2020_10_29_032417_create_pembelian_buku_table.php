<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePembelianBukuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembelian_buku', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('kode', 12);
            $table->date('tanggal');
            $table->unsignedBigInteger('id_user');
            $table->foreign('id_user')->references('id')->on('users');  
            $table->string('faktur');
            $table->unsignedBigInteger('id_pemasok');
            $table->foreign('id_pemasok')->references('id')->on('pemasok');
            $table->integer('total_harga');
            $table->integer('bayar');  
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pembelian_buku');
    }
}
