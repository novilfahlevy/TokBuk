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

  Route::group(['middleware' => 'posisi:Owner,Admin,Operator'], function() {
    //user
    Route::get('/pengguna', 'UserController@index')->name('user');
    Route::get('pengguna/create', 'UserController@create')->name('user.create');
    Route::post('pengguna/store', 'UserController@store')->name('user.store');
    Route::get('pengguna/{id}', 'UserController@edit')->name('user.edit');
    Route::put('pengguna/{id}/update', 'UserController@update')->name('user.update');
    Route::delete('pengguna/{id}', 'UserController@destroy')->name('user.destroy');

    //buku
    Route::get('/buku', 'BukuController@index')->name('buku');
    Route::post('/buku', 'BukuController@filter')->name('buku.filter');
    Route::get('buku/logs', 'BukuController@logs')->name('buku.logs');
    Route::get('buku/{id}/tambah', 'BukuController@tambahjml')->name('buku.tambah');
    Route::get('buku/{id}/detail', 'BukuController@detail')->name('buku.detail');
    Route::get('buku/create', 'BukuController@create')->name('buku.create');
    Route::post('buku/store', 'BukuController@store')->name('buku.store');
    Route::post('buku/tambahstore/{id}', 'BukuController@tambahstore')->name('buku.tambahstore');
    Route::get('buku/{id}', 'BukuController@edit')->name('buku.edit');
    Route::put('buku/{id}/update', 'BukuController@update')->name('buku.update');
    Route::delete('buku/{id}', 'BukuController@destroy')->name('buku.destroy');
    Route::post('buku/export', 'BukuController@export')->name('Pengadaan.export');

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
  
    //Distributor
    Route::get('/distributor', 'DistributorController@index')->name('distributor');
    Route::get('distributor/create', 'DistributorController@create')->name('distributor.create');
    Route::post('distributor/store', 'DistributorController@store')->name('distributor.store');
    Route::get('distributor/{id}', 'DistributorController@edit')->name('distributor.edit');
    Route::put('distributor/{id}/update', 'DistributorController@update')->name('distributor.update');
    Route::delete('distributor/{id}', 'DistributorController@destroy')->name('distributor.destroy');
  
    //Lokasi
    Route::get('lokasi', 'LokasiController@index')->name('lokasi');
    Route::post('lokasi/store', 'LokasiController@store')->name('lokasi.store');
    Route::put('lokasi/{id}/update', 'LokasiController@update')->name('lokasi.update');
    Route::delete('lokasi/{id}', 'LokasiController@destroy')->name('lokasi.destroy');

    //pembelian buku
    Route::get('pengadaan', 'PengadaanController@index')->name('pengadaan');
    Route::post('pengadaan', 'PengadaanController@filter')->name('pengadaan.filter');
    Route::get('pengadaan/{id}/detail', 'PengadaanController@detail')->name('pengadaan.detail');
    Route::get('pengadaan/create', 'PengadaanController@create')->name('pengadaan.create');
    Route::post('pengadaan/store', 'PengadaanController@store')->name('pengadaan.store');
    Route::post('pengadaan/export', 'PengadaanController@export')->name('pengadaan.export');
    Route::get('pengadaan/faktur/{id}', 'PengadaanController@faktur')->name('pengadaan.faktur');
    Route::get('pengadaan/laporan/{id}', 'PengadaanController@laporan')->name('pengadaan.laporan');
    Route::delete('pengadaan/{id}', 'PengadaanController@destroy')->name('pengadaan.destroy');
    Route::get('pengadaan/cetak/{id}', 'PengadaanController@cetak')->name('pengadaan.cetak');

    //laporan
    Route::get('laporan', 'LaporanController@index')->name('laporan');
    Route::get('laporan/penjualan/{dari}/{sampai}', 'LaporanController@pdfpenjualan')->name('laporan.penjualan');
    Route::get('laporan/pembelian/{dari}/{sampai}', 'LaporanController@pdfpembelian')->name('laporan.pembelian');
  });

  Route::group(['middleware' => 'posisi:Admin,Kasir,Owner'], function() {
    //transaksi
    Route::get('transaksi', 'TransaksiController@index')->name('transaksi');
    Route::post('transaksi', 'TransaksiController@filter')->name('transaksi.filter');
    Route::get('transaksi/create', 'TransaksiController@create')->name('transaksi.create');
    Route::post('transaksi/store', 'TransaksiController@store')->name('transaksi.store');
    Route::get('transaksi/edit/{id}', 'TransaksiController@edit')->name('transaksi.edit');
    Route::put('transaksi/update/{id}', 'TransaksiController@update')->name('transaksi.update');
    Route::get('transaksi/{id}/detail', 'TransaksiController@detail')->name('transaksi.detail');
    Route::post('transaksi/export', 'TransaksiController@export')->name('transaksi.export');
    Route::get('transaksi/nota/{id}', 'TransaksiController@nota')->name('transaksi.nota');
    Route::delete('transaksi/{id}', 'TransaksiController@destroy')->name('transaksi.destroy');
    Route::get('transaksi/cetak/{id}', 'TransaksiController@cetak')->name('transaksi.cetak');
  });

  Route::group(['middleware' => 'posisi:Admin,Owner'], function() {
    //pengaturan
    Route::get('pengaturan', 'PengaturanController@index')->name('pengaturan');
    Route::put('pengaturan.update', 'PengaturanController@update')->name('pengaturan.update');
  });
});