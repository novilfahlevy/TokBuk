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
Route::get('transaksi/barcode/{barcode}', 'Api\TransaksiController@getBukuByBarcode');
Route::get('transaksi/keyword/{keyword}', 'Api\TransaksiController@getBukuByKeyword');
Route::get('retur/{id}/buku', 'Api\ReturController@getDataBuku');
Route::get('pengadaan/buku', 'Api\PengadaanController@getDataBuku');
Route::post('laporan/transaksi', 'Api\LaporanController@transaksi');
Route::post('laporan/pengadaan', 'Api\LaporanController@pengadaan');