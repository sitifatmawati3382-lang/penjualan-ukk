<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\SuplierController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\LaporanController;
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
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('/barang', [BarangController::class, 'index'])->name('barang.index');
    Route::get('/barang/create', [BarangController::class, 'create'])->name('barang.create');
    Route::post('/barang', [BarangController::class, 'store'])->name('barang.store');
    Route::get('/barang/{id}/edit', [BarangController::class, 'edit'])->name('barang.edit');
    Route::patch('/barang/{id}', [BarangController::class, 'update'])->name('barang.update');
    Route::delete('/barang/{id}', [BarangController::class, 'destroy'])->name('barang.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/suplier', [SuplierController::class, 'index'])->name('suplier.index');
    Route::get('/suplier/create', [SuplierController::class, 'create'])->name('suplier.create');
    Route::post('/suplier', [SuplierController::class, 'store'])->name('suplier.store');
    Route::get('/suplier/{id}/edit', [SuplierController::class, 'edit'])->name('suplier.edit');
    Route::patch('/suplier/{id}', [SuplierController::class, 'update'])->name('suplier.update');
    Route::delete('/suplier/{id}', [SuplierController::class, 'destroy'])->name('suplier.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/pelanggan', [PelangganController::class, 'index'])->name('pelanggan.index');
    Route::get('/pelanggan/create', [PelangganController::class, 'create'])->name('pelanggan.create');
    Route::post('/pelanggan', [PelangganController::class, 'store'])->name('pelanggan.store');
    Route::get('/pelanggan/{id}/edit', [PelangganController::class, 'edit'])->name('pelanggan.edit');
    Route::patch('/pelanggan/{id}', [PelangganController::class, 'update'])->name('pelanggan.update');
    Route::delete('/pelanggan/{id}', [PelangganController::class, 'destroy'])->name('pelanggan.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index');
    Route::get('/kategori/create', [KategoriController::class, 'create'])->name('kategori.create');
    Route::post('/kategori', [KategoriController::class, 'store'])->name('kategori.store');
    Route::get('/kategori/{id}/edit', [KategoriController::class, 'edit'])->name('kategori.edit');
    Route::patch('/kategori/{id}', [KategoriController::class, 'update'])->name('kategori.update');
    Route::delete('/kategori/{id}', [KategoriController::class, 'destroy'])->name('kategori.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/kasir', [KasirController::class, 'index'])->name('kasir.index');
    Route::get('/kasir/create', [KasirController::class, 'create'])->name('kasir.create');
    Route::post('/kasir', [KasirController::class, 'store'])->name('kasir.store');
    Route::get('/kasir/{id}/edit', [KasirController::class, 'edit'])->name('kasir.edit');
    Route::patch('/kasir/{id}', [KasirController::class, 'update'])->name('kasir.update');
    Route::delete('/kasir/{id}', [KasirController::class, 'destroy'])->name('kasir.destroy');
    Route::get('/kasir/struk/{id_transaksi}', [KasirController::class, 'cetakStrukPdf'])->name('kasir.struk.pdf');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/laporan/harian', [LaporanController::class, 'harian'])->name('laporan.harian');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
