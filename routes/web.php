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

Route::resource('pemasukan', 'PemasukanController');
Route::resource('pengeluaran', 'PengeluaranController');

Route::group(['prefix' => 'tes'], function() {

	Route::get('light', function() {
		return view('light');
	});

});