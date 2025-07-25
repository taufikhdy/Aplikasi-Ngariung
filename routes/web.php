<?php

use App\Http\Controllers\adminController;
use App\Http\Controllers\wargaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginRegisterController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/', [LoginRegisterController::class, 'login']);

Route::controller(LoginRegisterController::class)->group(function () {
    route::get('/register', 'register')->name('register');
    route::post('/store', 'store')->name('store');

    route::get('/login', 'login')->name('login');
    route::post('/authenticate', 'authenticate')->name('authenticate');

    route::get('/home', 'home')->name('home');
    route::post('/logout', 'logout')->name('logout');
});





Route::controller(adminController::class)->group(function () {
    route::get('/admin/dashboard', 'dashboard')->name('admin.dashboard');

    route::get('/admin/profile', 'profile')->name('admin.profile');


    //data warga
    route::get('/admin/data_warga', 'dataWarga')->name('admin.dataWarga');

    //tambah warga
    route::get('/admin/data_warga/tambah_warga', 'tambahWarga')->name('admin.tambahWarga');
    route::post('/admin/data_warga/simpan_warga', 'simpanWarga')->name('admin.simpanWarga');

    //edit warga
    route::get('/admin/data_warga/{id}/edit', 'editWarga')->name('admin.editWarga');
    route::put('/admin/data_warga/{id}', 'updateWarga')->name('admin.updateWarga');

    //hapus warga
    route::delete('/admin/data_warga/hapus/{id}', 'hapusWarga')->name('admin.hapusWarga');


    //KAS
    route::get('/admin/kasiuran', 'kasiuran')->name('admin.kasiuran');

    route::get('/admin/kasiuran/tambah_kas', 'formTambahKas')->name('admin.formTambahKas');
    route::post('/admin/tambah_kas/tambah', 'tambahKas')->name('admin.kas.store');
    route::delete('/admin/hapus_kas/{id}', 'hapusKas')->name('admin.hapusKas');

    route::get('/admin/kasiuran/kelola_kas/{id}', 'kelolaKas')->name('admin.kelolaKas');
    route::post('/admin/kelola_kas/tambah_transaksi', 'tambahTransaksiKas')->name('admin.tambahTransaksiKas');

    route::get('/admin/kasiuran/pengeluaranKas/{id}', 'pengeluaranKas')->name('admin.pengeluaranKas');

    route::get('/admin/kasiuran/detailkas/{id}', 'detailkas')->name('admin.detailkas');




    route::get('/admin/riwayat-bayar', 'riwayatBayar')->name('admin.riwayat-bayar');
    route::get('/admin/bukti-bayar', 'buktiBayar')->name('admin.bukti-bayar');





    //TAMBAH IURAN
    route::get('/admin/kasiuran/tambah_iuran', 'formTambahIuran')->name('admin.formTambahIuran');
    route::post('/admin/kasiuran/tambah_iuran/tambah', 'tambahIuran')->name('admin.tambahIuran');

    //HAPUS IURAN
    route::delete('/admin/hapus_iuran/{id}', 'hapusIuran')->name('admin.hapusIuran');


    //KONFIRMASI IURAN
    route::get('/admin/kasiuran/kelola_iuran/{id}', 'kelolaIuran')->name('admin.kelolaIuran');
    route::post('/admin/konfirmasi_iuran/{id}', 'konfirmasiIuran')->name('admin.konfirmasiIuran');





    //BERITA
    route::get('/admin/berita', 'berita')->name('admin.berita');
    route::get('/admin/berita/tambah_berita', 'formTambahBerita')->name('admin.formTambahBerita');
    route::post('/admin/tambah_berita/post', 'tambahBerita')->name('admin.tambahBerita');

    route::get('admin/berita/detail/{id}', 'detailBerita')->name('admin.detailBerita');
    route::delete('/admin/berita/hapus/{id}', 'hapusBerita')->name('admin.hapusBerita');


    route::get('/admin/surat', 'surat')->name('admin.surat');
    route::get('/admin/surat/detailSurat', 'detailSurat')->name('admin.detailSurat');

});




// WARGA

Route::controller(wargaController::class)->group(function () {
    route::get('/warga/dashboard', 'dashboard')->name('warga.dashboard');

    route::get('/warga/profile', 'profile')->name('warga.profile');


    route::get('/warga/detailkas/{id}', 'detailkas')->name('warga.detailkas');
    route::get('/warga/pengeluaranKas{id}', 'pengeluaranKas')->name('warga.pengeluaranKas');


    route::get('/warga/kasiuran', 'kasiuran')->name('warga.kasiuran');

    // BAYAR IURAN
    route::post('warga/iuran/bayar/{id}', 'bayarIuran')->name('warga.bayarIuran');

    route::get('/warga/berita', 'berita')->name('warga.berita');
    route::get('/warga/berita/detail/{id}', 'detailBerita')->name('warga.detailBerita');


    route::get('/warga/riwayat-bayar', 'riwayatBayar')->name('warga.riwayat-bayar');
    route::get('/warga/bukti-bayar', 'buktiBayar')->name('warga.bukti-bayar');




    // SURAT
    route::get('/warga/surat', 'surat')->name('warga.surat');
    route::post('/warga/surat/ajukan_surat/SKCK', 'ajukanSkck')->name('warga.ajukanSkck');

    route::get('/warga/detailSurat', 'detailSurat')->name('warga.detailSurat');

});
