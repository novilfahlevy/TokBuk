<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReturTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('retur', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->string('kode', 12);
      $table->unsignedBigInteger('id_pengadaan');
      $table->foreign('id_pengadaan')->references('id')->on('pengadaan')->onDelete('cascade');
      $table->unsignedBigInteger('id_user')->nullable();
      $table->foreign('id_user')->references('id')->on('users');
      $table->integer('total_dana_pengembalian');
      $table->date('tanggal');
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
    Schema::dropIfExists('retur');
  }
}
