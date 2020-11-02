<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::redirect('/', '/home');
Auth::routes();

Route::group(['middleware' => 'auth'], function() {
  Route::get('/home', 'HomeController@index')->name('home');

  //profil
  Route::get('/profil', 'ProfilController@index')->name('profil');
  Route::put('/profil/update', 'ProfilController@update')->name('profil.update');
  Route::put('/profil/password', 'ProfilController@changePassword')->name('profil.password');

  //user
  Route::get('/datauser', 'UserController@index')->name('user');
  Route::get('datauser/create', 'UserController@create')->name('user.create');
  Route::post('datauser/store', 'UserController@store')->name('user.store');
  Route::get('datauser/{id}', 'UserController@edit')->name('user.edit');
  Route::put('datauser/{id}/update', 'UserController@update')->name('user.update');
  Route::delete('datauser/{id}', 'UserController@destroy')->name('user.destroy');

  //buku
  Route::get('/databuku', 'BukuController@index')->name('buku');
  Route::post('/databuku', 'BukuController@filter')->name('buku.filter');
  Route::get('databuku/logs', 'BukuController@logs')->name('buku.logs');
  Route::get('databuku/{id}/tambah', 'BukuController@tambahjml')->name('buku.tambah');
  Route::get('databuku/{id}/detail', 'BukuController@detail')->name('buku.detail');
  Route::get('databuku/create', 'BukuController@create')->name('buku.create');
  Route::post('databuku/store', 'BukuController@store')->name('buku.store');
  Route::post('databuku/tambahstore/{id}', 'BukuController@tambahstore')->name('buku.tambahstore');
  Route::get('databuku/{id}', 'BukuController@edit')->name('buku.edit');
  Route::put('databuku/{id}/update', 'BukuController@update')->name('buku.update');
  Route::delete('databuku/{id}', 'BukuController@destroy')->name('buku.destroy');
  Route::post('databuku/export', 'BukuController@export')->name('pembelianbuku.export');


  //penulis
  Route::get('/penulis', 'PenulisController@index')->name('penulis');
  Route::post('penulis/store', 'PenulisController@store')->name('penulis.store');
  Route::put('penulis/{id}/update', 'PenulisController@update')->name('penulis.update');
  Route::delete('penulis/{id}', 'PenulisController@destroy')->name('penulis.destroy');

  //penerbit
  Route::get('/penerbit', 'PenerbitController@index')->name('penerbit');
  Route::get('penerbit/create', 'PenerbitController@create')->name('penerbit.create');
  Route::post('penerbit/store', 'PenerbitController@store')->name('penerbit.store');
  Route::get('penerbit/{id}', 'PenerbitController@edit')->name('penerbit.edit');
  Route::put('penerbit/{id}/update', 'PenerbitController@update')->name('penerbit.update');
  Route::delete('penerbit/{id}', 'PenerbitController@destroy')->name('penerbit.destroy');

  //Kategori
  Route::get('/kategori', 'KategoriController@index')->name('kategori');
  Route::post('kategori/store', 'KategoriController@store')->name('kategori.store');
  Route::put('kategori/{id}/update', 'KategoriController@update')->name('kategori.update');
  Route::delete('kategori/{id}', 'KategoriController@destroy')->name('kategori.destroy');

  //Pemasok
  Route::get('/pemasok', 'PemasokController@index')->name('pemasok');
  Route::get('pemasok/create', 'PemasokController@create')->name('pemasok.create');
  Route::post('pemasok/store', 'PemasokController@store')->name('pemasok.store');
  Route::get('pemasok/{id}', 'PemasokController@edit')->name('pemasok.edit');
  Route::put('pemasok/{id}/update', 'PemasokController@update')->name('pemasok.update');
  Route::delete('pemasok/{id}', 'PemasokController@destroy')->name('pemasok.destroy');

  //Lokasi
  Route::get('lokasi', 'LokasiController@index')->name('lokasi');
  Route::post('lokasi/store', 'LokasiController@store')->name('lokasi.store');
  Route::put('lokasi/{id}/update', 'LokasiController@update')->name('lokasi.update');
  Route::delete('lokasi/{id}', 'LokasiController@destroy')->name('lokasi.destroy');

  //transaksi
  Route::get('transaksi', 'TransaksiController@index')->name('transaksi');
  Route::post('transaksi', 'TransaksiController@filter')->name('transaksi.filter');
  Route::get('transaksi/create', 'TransaksiController@create')->name('transaksi.create');
  Route::post('transaksi/store', 'TransaksiController@store')->name('transaksi.store');
  Route::get('transaksi/edit/{id}', 'TransaksiController@edit')->name('transaksi.edit');
  Route::put('transaksi/update/{id}', 'TransaksiController@update')->name('transaksi.update');
  Route::get('transaksi/{id}/detail', 'TransaksiController@detail')->name('transaksi.detail');
  Route::post('transaksi/export', 'TransaksiController@export')->name('transaksi.export');
  Route::delete('transaksi/{id}', 'TransaksiController@destroy')->name('transaksi.destroy');

  //pembelian buku
  Route::get('pembelian-buku', 'PembelianBukuController@index')->name('pembelian-buku');
  Route::post('pembelian-buku', 'PembelianBukuController@filter')->name('pembelian-buku.filter');
  Route::get('pembelian-buku/{id}/detail', 'PembelianBukuController@detail')->name('pembelian-buku.detail');
  Route::get('pembelian-buku/create', 'PembelianBukuController@create')->name('pembelian-buku.create');
  Route::post('pembelian-buku/store', 'PembelianBukuController@store')->name('pembelian-buku.store');
  Route::post('pembelian-buku/export', 'PembelianBukuController@export')->name('pembelian-buku.export');
  Route::get('pembelian-buku/faktur/{id}', 'PembelianBukuController@faktur')->name('pembelian-buku.faktur');
  Route::delete('pembelian-buku/{id}', 'PembelianBukuController@destroy')->name('pembelian-buku.destroy');
});