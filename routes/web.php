<?php

use App\Http\Controllers\BarangController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\SuplierController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

// --- ROUTE AUTENTIKASI ---
// Route untuk menampilkan form login
Route::get('/login', [LoginController::class, 'form_login'])->name('login');
// Route untuk memproses login
Route::post('/login', [LoginController::class, 'proses_login'])->name('login.proses_login');
// Route untuk logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function(){

    Route::get('/dashboard', [HomeController::class,'index']);

    // !!! ROUTE MILIK BARANG !!!
    // Route untuk menampilkan daftar semua barang
    Route::get('/barang', [BarangController::class, 'index'])->name('barang.index');
    Route::get('/barang/create', [BarangController::class, 'create'])->name('barang.create');
    Route::post('/barang', [BarangController::class, 'store'])->name('barang.store');
    // Route untuk menampilkan form ubah data barang
    Route::get('/barang/{id}/edit', [BarangController::class, 'edit'])->name('barang.edit');
    // Route untuk memproses data yang diubah (metode PUT)
    Route::put('/barang/{id}', [BarangController::class, 'update'])->name('barang.update');
    // Route untuk menghapus data barang (metode DELETE)
    Route::delete('/barang/{id}', [BarangController::class, 'destroy'])->name('barang.destroy');

    //!!! ROUTE MILIK SUPLIER !!!

    Route::get('/suplier',[SuplierController::class,'index'])->name('suplier.index');
    Route::get('/suplier/create',[SuplierController::class,'create'])->name('suplier.create');
    Route::post('/suplier',[SuplierController::class,'store'])->name('suplier.store');
    Route::get('/suplier/{id}/edit', [SuplierController::class, 'edit'])->name('suplier.edit');
    // Route untuk memproses data yang diubah (metode PUT)
    Route::put('/suplier/{id}', [SuplierController::class, 'update'])->name('suplier.update');
    // Route untuk menghapus data barang (metode DELETE)
    Route::delete('/suplier/{id}', [SuplierController::class, 'destroy'])->name('suplier.destroy');


    //!!! ROUTE MILIK PELANGGAN !!!
    Route::get('/pelanggan',[PelangganController::class,'index'])->name('pelanggan.index');
    Route::get('/pelanggan/create',[PelangganController::class,'create'])->name('pelanggan.create');
    Route::post('/pelanggan',[PelangganController::class,'store'])->name(name: 'pelanggan.store');
    Route::get('/pelanggan/{id}/edit', [PelangganController::class, 'edit'])->name('pelanggan.edit');
    // Route untuk memproses data yang diubah (metode PUT)
    Route::put('/pelanggan/{id}', [PelangganController::class, 'update'])->name('pelanggan.update');
    // Route untuk menghapus data barang (metode DELETE)
    Route::delete('/pelanggan/{id}', [PelangganController::class, 'destroy'])->name('pelanggan.destroy');

    //!!! ROUTE MILIK KATEGORI !!!
    Route::get('/kategori',[KategoriController::class,'index'])->name('kategori.index');
    Route::get('/kategori/create', [KategoriController::class, 'create'])->name('kategori.create');
    Route::post('/kategori', [KategoriController::class, 'store'])->name('kategori.store');
    Route::get('/kategori/{id}/edit', [KategoriController::class, 'edit'])->name('kategori.edit');

    // Route untuk memproses data yang diubah (metode PUT)
    Route::put('/kategori/{id}', [KategoriController::class, 'update'])->name('kategori.update');

    // Route untuk menghapus data kategori (metode DELETE)
    Route::delete('/kategori/{id}', [KategoriController::class, 'destroy'])->name('kategori.destroy');


    // Rute untuk Sistem Kasir
    Route::get('/kasir', [KasirController::class, 'index'])->name('kasir.index');
    Route::post('/kasir', [KasirController::class, 'store'])->name('kasir.store');

    // Route untuk pencarian pelanggan (tambahan fitur)
    Route::get('/kasir/cari-pelanggan-hp/{no_hp}', [KasirController::class, 'cariPelangganByHp']);
    Route::get('/laporan/harian', [LaporanController::class, 'harian'])->name('laporan.harian');
    Route::get('/kasir/struk/{id_transaksi}', [KasirController::class, 'cetakStrukPdf'])->name('kasir.struk.pdf');
});
