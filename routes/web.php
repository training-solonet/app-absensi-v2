<?php

use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\UIDController;
use App\Models\Absensi;
use App\Models\Siswa;
use Illuminate\Support\Facades\Route;

// Muat rute autentikasi
require __DIR__.'/auth.php';

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group.
|
*/

// Rute untuk tamu (belum login)
Route::get('/', function () {
    return redirect()->route('login');
});

// Rute yang membutuhkan autentikasi
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    // Dashboard route
    Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

    // Rute absensi
    Route::get('/absensi', [AbsensiController::class, 'index'])->name('absensi');
    Route::get('/terlambat', [AbsensiController::class, 'terlambat'])->name('absensi.terlambat');

    // Rute untuk halaman profile
    Route::view('/profile', 'profile')->name('profile');

    // Rute resource untuk siswa
    Route::resource('/siswa', SiswaController::class);
});

// Rute untuk data UID (tidak memerlukan autentikasi)
Route::get('/data-uid', [UIDController::class, 'index'])->name('data-uid');
Route::post('/uid/update-name', [UIDController::class, 'updateName'])->name('uid.update-name');
