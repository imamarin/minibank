<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Middleware\StatusLogin;
use \App\Http\Middleware\StatusLoginNasabah;
use Illuminate\Support\Facades\DB;
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
    return view('welcome');
});

Route::middleware('statusloginnasabah')->group(function () {
    Route::get('/nasabah/home', 'NasabahController@home')->name('home_nasabah');
    Route::get('/nasabah/profil', 'NasabahController@profil')->name('profil_nasabah');
    Route::get('/nasabah/inforek', 'NasabahController@inforekening')->name('inforekening_nasabah');
    Route::post('/nasabah/infosaldo', 'NasabahController@infosaldo')->name('infosaldo_nasabah');
    Route::post('/nasabah/infomutasi', 'NasabahController@infomutasi')->name('infomutasi_nasabah');
    Route::get('/nasabah/transfer', 'NasabahController@transfer')->name('transfer_nasabah');
    Route::post('/nasabah/prosestransfer', 'NasabahController@prosestransfer')->name('nasabah.prosestransfer');
    Route::post('/nasabah/bayartransfer', 'NasabahController@bayartransfer')->name('nasabah.bayartransfer');
    Route::get('/nasabah/pembayaran', 'NasabahController@pembayaran')->name('nasabah.pembayaran');
    Route::post('/nasabah/prosespembayaran', 'NasabahController@prosespembayaran')->name('nasabah.prosespembayaran');
    Route::get('/scanner', 'ScannerController@index')->name('nasabah.scanner');
});

Route::middleware('statuslogin')->group(function () {
    //
    Route::get('/home', 'HomeController@index')->name('home');

    Route::get('/nasabah', 'NasabahController@index')->name('nasabah');
    Route::get('/nasabah/input', 'NasabahController@input')->name('nasabah_input');
    Route::post('/nasabah/simpan', 'NasabahController@simpan')->name('nasabah_simpan');
    Route::get('/nasabah/edit/{id}', 'NasabahController@edit')->name('nasabah_edit');
    Route::get('/nasabah/hapus/{id}', 'NasabahController@hapus')->name('nasabah_hapus');
    Route::post('/nasabah/update', 'NasabahController@update')->name('nasabah_update');
    Route::post('/nasabah/carisiswa', 'NasabahController@carisiswa')->name('nasabah_cari_siswa');
    Route::post('/nasabah/cari', 'NasabahController@cari')->name('nasabah.cari');

    Route::get('/pegawai', 'PegawaiController@index')->name('pegawai');
    Route::get('/pegawai/input', 'PegawaiController@input')->name('pegawai_input');
    Route::post('/pegawai/simpan', 'PegawaiController@simpan')->name('pegawai_simpan');
    Route::get('/pegawai/edit/{id}', 'PegawaiController@edit')->name('pegawai_edit');
    Route::post('/pegawai/update', 'PegawaiController@update')->name('pegawai_update');
    Route::get('/pegawai/hapus/{id}', 'PegawaiController@hapus')->name('pegawai_hapus');

    Route::get('/rekening', 'RekeningController@index')->name('rekening');
    Route::get('/rekening/input', 'RekeningController@input')->name('rekening_input');
    Route::post('/rekening/simpan', 'RekeningController@simpan')->name('rekening_simpan');
    Route::post('/rekening/simpansub', 'RekeningController@simpansub')->name('rekening_simpan_sub');
    Route::get('/rekening/edit/{id}', 'RekeningController@edit')->name('rekening_edit');
    Route::post('/rekening/update', 'RekeningController@update')->name('rekening_update');
    Route::get('/rekening/hapus/{id}', 'RekeningController@hapus')->name('rekening_hapus');
    Route::get('/rekening/sub/{id}', 'RekeningController@sub')->name('rekening_sub');
    Route::post('/rekening/updatesub', 'RekeningController@updatesub')->name('rekening_update_sub');

    Route::get('/laporantransaksi', 'RekeningController@koran')->name('rekening_lap_transaksi');
    Route::get('/laporantransaksi/print', 'RekeningController@printlaptransaksi')->name('rekening_print_lap_transaksi');
    Route::get('/laporantransaksi/excel', 'RekeningController@excellaptransaksi')->name('rekening_excel_lap_transaksi');

    Route::get('/tabungan', 'TabunganController@index')->name('tabungan');
    Route::get('/tabungan/input', 'TabunganController@input')->name('tabungan_input');
    Route::post('/tabungan/simpan', 'TabunganController@simpan')->name('tabungan_simpan');
    Route::post('/tabungan/cari', 'TabunganController@cari')->name('tabungan.cari');
    Route::get('/tabungan/hapus/{id}', 'TabunganController@hapus')->name('tabungan_hapus');

    Route::get('/transfer', 'TransferController@index')->name('transfer');
    Route::get('/transfer/input', 'TransferController@input')->name('transfer_input');
    Route::post('/transfer/simpan', 'TransferController@simpan')->name('transfer_simpan');
    Route::post('/transfer/cari', 'TransferController@cari')->name('transfer.cari');
    Route::post('/transfer/caripembayaran', 'TransferController@cariPembayaran')->name('transfer.caripembayaran');
    Route::post('/transfer/carinominalpembayaran', 'TransferController@cariNominalPembayaran')->name('transfer.carinominalpembayaran');
    Route::get('/transfer/hapus/{id}', 'TransferController@hapus')->name('transfer_hapus');

    Route::get('/autodebet', 'AutodebetController@index')->name('autodebet');
    Route::post('/autodebet/simpan', 'AutodebetController@simpan')->name('autodebet_simpan');
    Route::get('/autodebet/hapus/{id}', 'AutodebetController@hapus')->name('autodebet_hapus');
    Route::get('/autodebet/proses', 'AutodebetController@proses')->name('autodebet.proses');
    Route::get('/tagihan', 'ReqinvoiceController@index')->name('tagihan.index');
    Route::post('/tagihan/lokal', 'ReqinvoiceController@input')->name('tagihan.input');
    Route::post('/tagihan/batal', 'ReqinvoiceController@batal')->name('tagihan.batal');
    Route::get('/tagihan/add', 'ReqinvoiceController@add')->name('tagihan.add');
    Route::get('/tagihan/edit/{id}', 'ReqinvoiceController@edit')->name('tagihan_edit');
    Route::post('/tagihan/update', 'ReqinvoiceController@update')->name('tagihan_update');

    Route::get('/printtabungan', 'PrinttabunganController@index')->name('printtabungan');
    Route::get('/printtabungan/cari', 'PrinttabunganController@cari')->name('cariprinttabungan');
    Route::post('/printtabungan/cetak', 'PrinttabunganController@cetak')->name('cetakprinttabungan');
    Route::get('/admin', 'HomeController@index');
});

Route::post('/payment/notif', 'PaymentController@notif')->name('payment.notif');
Route::post('/auth', 'LoginController@cari');
Route::get('/login', 'LoginController@index');
Route::get('/logout', 'LoginController@out');
Route::get('/testiak', 'TestiakController@index');
Route::post('/testiak/coba', 'TestiakController@coba')->name('testiak.coba');
Route::get('/hosttohost', 'HosttohostController@index')->name('hosttohost.index');
Route::get('/simulasi', 'SimulasiController@index')->name('simulasi.index');
Route::post('/simulasi/proses', 'SimulasiController@proses')->name('simulasi.proses');





