<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Master\AkunController;
use App\Http\Controllers\Master\AnggotaController;
use App\Http\Controllers\Master\KategoriController;
use App\Http\Controllers\PemasukanController;
use App\Http\Controllers\PengeluaranController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


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


Auth::routes();
Route::get('/', [LoginController::class, 'showLoginForm'])->name('Login');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('Dashboard');

Route::prefix('Akun')->middleware('auth')->group(function () {
    Route::get('/', [AkunController::class, 'index'])->name('Akun.index');
    Route::post('/cari_akun', [AkunController::class, 'cari_akun'])->name('Akun.cari_akun');
    Route::post('/tambah_akun', [AkunController::class, 'tambah_akun'])->name('Akun.tambah_akun');
    Route::post('/ubah_akun/{id}', [AkunController::class, 'ubah_akun'])->name('Akun.ubah_akun');
    Route::delete('/hapus_akun/{id}', [AkunController::class, 'hapus_akun'])->name('Akun.hapus_akun');
});

Route::prefix('Kategori')->middleware('auth')->group(function () {
    Route::get('/', [KategoriController::class, 'index'])->name('Kategori.index');
    Route::post('/cari_kategori', [KategoriController::class, 'cari_kategori'])->name('Kategori.cari_kategori');
    Route::post('/tambah_kategori', [KategoriController::class, 'tambah_kategori'])->name('Kategori.tambah_kategori');
    Route::post('/ubah_kategori/{id}', [KategoriController::class, 'ubah_kategori'])->name('Kategori.ubah_kategori');
    Route::delete('/hapus_kategori/{id}', [KategoriController::class, 'hapus_kategori'])->name('Kategori.hapus_kategori');
});

Route::prefix('Anggota')->middleware('auth')->group(function () {
    Route::get('/', [AnggotaController::class, 'index'])->name('Anggota.index');
    Route::post('/cari_anggota', [AnggotaController::class, 'cari_anggota'])->name('Anggota.cari_anggota');
    Route::post('/tambah_anggota', [AnggotaController::class, 'tambah_anggota'])->name('Anggota.tambah_anggota');
    Route::post('/ubah_anggota/{id}', [AnggotaController::class, 'ubah_anggota'])->name('Anggota.ubah_anggota');
    Route::delete('/hapus_anggota/{id}', [AnggotaController::class, 'hapus_anggota'])->name('Anggota.hapus_anggota');
});

Route::prefix('Pengeluaran')->middleware('auth')->group(function () {
    Route::get('/', [PengeluaranController::class, 'index'])->name('Pengeluaran.index');
    Route::post('/cari_pengeluaran', [PengeluaranController::class, 'cari_pengeluaran'])->name('Pengeluaran.cari_pengeluaran');
    Route::post('/tambah_pengeluaran', [PengeluaranController::class, 'tambah_pengeluaran'])->name('Pengeluaran.tambah_pengeluaran');
    Route::post('/ubah_pengeluaran/{id}', [PengeluaranController::class, 'ubah_pengeluaran'])->name('Pengeluaran.ubah_pengeluaran');
    Route::delete('/hapus_pengeluaran/{id}', [PengeluaranController::class, 'hapus_pengeluaran'])->name('Pengeluaran.hapus_pengeluaran');
});

Route::prefix('Pemasukan')->middleware('auth')->group(function () {
    Route::get('/', [PemasukanController::class, 'index'])->name('Pemasukan.index');
    Route::post('/cari_pemasukan', [PemasukanController::class, 'cari_pemasukan'])->name('Pemasukan.cari_pemasukan');
    Route::post('/tambah_pemasukan', [PemasukanController::class, 'tambah_pemasukan'])->name('Pemasukan.tambah_pemasukan');
    Route::post('/ubah_pemasukan/{id}', [PemasukanController::class, 'ubah_pemasukan'])->name('Pemasukan.ubah_pemasukan');
    Route::delete('/hapus_pemasukan/{id}', [PemasukanController::class, 'hapus_pemasukan'])->name('Pemasukan.hapus_pemasukan');
});
