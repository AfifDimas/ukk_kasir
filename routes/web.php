<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/profile', 'ProfileController@index')->name('profile');
Route::put('/profile', 'ProfileController@update')->name('profile.update');
Route::get('/petugas', 'UserController@index')->name('petugas');
Route::get('/petugas/data', 'UserController@data')->name('petugas.data');
Route::post('/petugas/create', 'UserController@create')->name('petugas.create');
Route::get('/petugas/getUser/{id}', 'UserController@getUser')->name('petugas.getUser');
Route::put('/petugas/update', 'UserController@update')->name('petugas.update');
Route::get('/petugas/delete/{id}', 'UserController@delete')->name('petugas.delete');


Route::get('/penjualan', 'PenjualanController@index')->name('penjualan');
Route::get('/penjualan/create', 'PenjualanController@create')->name('penjualan.baru');
Route::get('/penjualan/dataProduk', 'PenjualanController@allDataProduk')->name('penjualan.dataProduk');
Route::get('/penjualan/tambahProduk/{id}', 'PenjualanDetailController@tambahProduk')->name('penjualan.tambahProduk');
Route::get('/penjualan/data', 'PenjualanController@data')->name('penjualan.data');
Route::delete('/penjualan/hapusData/{id}', 'PenjualanDetailController@hapusData')->name('penjualan.hapusData');
Route::put('/penjualan/tambahJmlProduk/{id}', 'PenjualanDetailController@tambahJmlProduk')->name('penjualan.tambahJmlProduk');
Route::put('/penjualan/update', 'PenjualanDetailController@update')->name('penjualan.update');
Route::get('/penjualan/batal', 'PenjualanController@batal')->name('penjualan.batal');
Route::get('/penjualan/detail/{id}', 'PenjualanDetailController@data')->name('penjualan.detail');
Route::get('/penjualanDetail/{id}', 'PenjualanDetailController@index')->name('penjualanDetail');
Route::get('/penjualanDetail/loadForm/{diskon}/{subtotal}/{diterima}', 'PenjualanDetailController@loadForm')->name('penjualanDetail.loadForm');
Route::put('/penjualan/simpan', 'PenjualanController@update')->name('penjualan.simpan');
Route::get('/cetakNota', 'LaporanController@cetakNota')->name('cetakNota');


Route::get('/laporan', 'LaporanController@index')->name('laporan');
Route::get('/laporan/data', 'LaporanController@data')->name('laporan.data');
Route::post('/laporan/cetakPDF', 'LaporanController@cetakPDF')->name('laporan.cetakPDF');


Route::get('/produk', 'ProdukController@index')->name('produk');
Route::get('/produk/tambah', 'ProdukController@tambah')->name('produk.tambah');
Route::get('/produk/data', 'ProdukController@data')->name('produk.data');
Route::put('/produk/update', 'ProdukController@update')->name('produk.update');
Route::delete('/produk/delete/{id}', 'ProdukController@delete')->name('produk.delete');
Route::get('produk/selectProduk/{id}', 'ProdukController@selectProduk')->name('produk.selectProduk');

Route::get('pelanggan/new', 'PelangganController@create')->name('pelanggan.new');