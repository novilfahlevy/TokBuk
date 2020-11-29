<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengaturanTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('pengaturan', function (Blueprint $table) {
      $table->id();
      $table->string('nama_toko');
      $table->string('email');
      $table->string('telepon');
      $table->string('alamat');
      $table->integer('limit_stok')->default(0);
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
    Schema::dropIfExists('pengaturan');
  }
}
