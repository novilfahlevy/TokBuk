<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailReturTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('detail_retur', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->unsignedBigInteger('id_retur');
      $table->foreign('id_retur')->references('id')->on('retur')->onDelete('cascade');
      $table->unsignedBigInteger('id_detail_pengadaan');
      $table->foreign('id_detail_pengadaan')->references('id')->on('detail_pengadaan')->onDelete('cascade');
      $table->integer('jumlah');
      $table->integer('dana_pengembalian');
      $table->string('keterangan');
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
    Schema::dropIfExists('detail_retur');
  }
}
