<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('dasbor', 'DasborController@chart');
Route::get('transaksi/buku', 'Api\TransaksiController@getDataBuku');
Route::get('retur/{id}/buku', 'Api\ReturController@getDataBuku');
Route::get('pengadaan/buku', 'Api\PengadaanController@getDataBuku');
Route::post('laporan/transaksi', 'LaporanController@transaksi');
Route::post('laporan/pengadaan', 'LaporanController@pengadaan');