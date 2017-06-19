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

Route::get('/', function () {
    return view('beranda');
});


Route::resource('karyawan', 'KaryawanController');
Route::resource('pelanggan', 'PelangganController');
Route::resource('barang', 'BarangController');
Route::resource('jasa', 'JasaController');
Route::resource('cuci', 'CuciController');

Route::group(['prefix' => 'harga'], function() {
	Route::get('/{id_pelanggan}', ['uses' => 'HargaController@index', 'as' => 'harga.index']);
	Route::get('/{id_pelanggan}/create', ['uses' => 'HargaController@create', 'as' => 'harga.create']);
	Route::post('/{id_pelanggan}/store', ['uses' => 'HargaController@store', 'as' => 'harga.store']);
	Route::get('/{id_pelanggan}/{id_barang}/{id_jasa}/edit/', ['uses' => 'HargaController@edit', 'as' => 'harga.edit']);
	Route::match(['PUT', 'PATCH'], 'update/{id_pelanggan}/{id_barang}/{id_jasa}', ['uses' => 'HargaController@update', 'as' => 'harga.update']);
	Route::delete('{id_pelanggan}/{id_barang}/{id_jasa}', ['uses' => 'HargaController@destroy', 'as' => 'harga.delete']);
	Route::get('/{id_pelanggan}/check', ['uses' => 'HargaController@check_price', 'as' => 'harga.check']);
});

Route::resource('order', 'OrderController');
Route::match(['PUT', 'PATCH'], 'print_po/{id}', ['uses' => 'OrderController@print_po', 'as' => 'order.print_po']);
Route::post('order/bill', ['uses' => 'OrderController@bill', 'as' => 'order.bill']);
Route::get('order/{id}/payment', ['uses' => 'OrderController@payment', 'as' => 'order.payment']);
Route::match(['PUT', 'PATCH'], 'paid/{id}',['uses' => 'OrderController@paid', 'as' => 'order.paid']);

Route::resource('pemasukan', 'PemasukanController');
Route::resource('pengeluaran', 'PengeluaranController');

Route::group(['prefix' => 'cetak'], function() {
	Route::get('pemasukan/{id}', ['uses' => 'PemasukanController@cetak', 'as' => 'pemasukan.cetak']);
});