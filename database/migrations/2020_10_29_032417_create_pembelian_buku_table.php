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
            $table->string('faktur')->nullable();
            $table->unsignedBigInteger('id_distributor')->nullable();
            $table->foreign('id_distributor')->references('id')->on('distributor');
            $table->integer('total_harga');
            $table->integer('bayar');  
            $table->text('keterangan')->nullable();
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
