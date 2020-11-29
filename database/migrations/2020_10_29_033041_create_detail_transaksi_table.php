<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetailTransaksiTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('detail_transaksi', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->unsignedBigInteger('id_transaksi');
      $table->foreign('id_transaksi')->references('id')->on('transaksi')->onDelete('cascade');
      $table->unsignedBigInteger('id_buku')->nullable();
      $table->foreign('id_buku')->references('id')->on('buku');
      $table->integer('jumlah');
      $table->integer('harga');
      $table->integer('diskon')->nullable();
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
    Schema::dropIfExists('detail_transaksi');
  }
}
