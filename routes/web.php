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

Auth::routes();
// Route::get('/', function () {
    // $nomer = kikiLaundry\Order::nomer_urut();
    // $pelanggan = kikiLaundry\Pelanggan::pluck('nama', 'id')->all();
    // return view('beranda', compact('nomer', 'pelanggan'));
// });

Route::get('/', 'BerandaController@index');
Route::resource('karyawan', 'KaryawanController');
Route::resource('pelanggan', 'PelangganController');
Route::resource('barang', 'BarangController');
Route::resource('jasa', 'JasaController');
Route::resource('cuci', 'CuciController');

Route::group(['prefix' => 'harga'], function () {
    Route::get('/{id_pelanggan}', ['uses' => 'HargaController@index', 'as' => 'harga.index']);
    Route::get('/{id_pelanggan}/create', ['uses' => 'HargaController@create', 'as' => 'harga.create']);
    Route::post('/{id_pelanggan}/store', ['uses' => 'HargaController@store', 'as' => 'harga.store']);
    Route::get('/{id_pelanggan}/{id_barang}/{id_cuci}/edit/', ['uses' => 'HargaController@edit', 'as' => 'harga.edit']);
    Route::match(['PUT', 'PATCH'], 'update/{id_pelanggan}/{id_barang}/{id_cuci}', ['uses' => 'HargaController@update', 'as' => 'harga.update']);
    Route::delete('{id_pelanggan}/{id_barang}/{id_cuci}', ['uses' => 'HargaController@destroy', 'as' => 'harga.delete']);
    Route::get('/{id_pelanggan}/check', ['uses' => 'HargaController@check_price', 'as' => 'harga.check']);
});

Route::group(['prefix' => 'absen'], function () {
    Route::post('find', ['uses' => 'AbsensiController@find', 'as' => 'absen.find']);
    Route::post('submit', ['uses' => 'AbsensiController@submit', 'as' => 'absen.submit']);
});

Route::resource('order', 'OrderController');
Route::get('order/{id}/payment', ['uses' => 'OrderController@payment', 'as' => 'order.payment']);
Route::match(['PUT', 'PATCH'], 'paid/{id}', ['uses' => 'OrderController@paid', 'as' => 'order.paid']);

Route::resource('pemasukan', 'PemasukanController');
Route::resource('pengeluaran', 'PengeluaranController');

Route::group(['prefix' => 'cetak'], function () {
    Route::get('harga/{id}', ['uses' => 'CetakController@harga', 'as' => 'cetak.harga']);
    Route::get('pemasukan/{id}', ['uses' => 'CetakController@pemasukan', 'as' => 'cetak.pemasukan']);
    Route::match(['PUT', 'PATCH'], 'po', ['uses' => 'CetakController@po', 'as' => 'cetak.po']);
    Route::post('tagihan', ['uses' => 'CetakController@tagihan', 'as' => 'cetak.tagihan']);
});

Route::group(['prefix' => 'gaji'], function () {
    Route::get('/', ['uses' => 'GajiController@index', 'as' => 'gaji.index']);
    Route::post('show', ['uses' => 'GajiController@show', 'as' => 'gaji.show']);
});


Route::get('/home', 'HomeController@index')->name('home');
