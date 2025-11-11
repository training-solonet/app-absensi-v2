<?php

use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\AbsensiInputController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\UIDController;
use App\Models\Absensi;
use App\Models\Siswa;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Public dashboard route (no auth middleware)
Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

// Public UID input route
Route::get('/absensi-uid', [AbsensiInputController::class, 'index'])->name('absensi-uid');
Route::post('/absensi-uid', [AbsensiInputController::class, 'store'])->name('absensi-uid.store');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    // Rute absensi
    Route::prefix('absensi')->group(function () {
        Route::get('/', [AbsensiController::class, 'index'])->name('absensi');
        Route::get('/terlambat', [AbsensiController::class, 'terlambat'])->name('absensi.terlambat');
        Route::match(['put', 'post'], '/{id}', [AbsensiController::class, 'update'])->name('absensi.update');
    });

    // Rute untuk halaman profile
    Route::view('/profile', 'profile')->name('profile');

    // Rute resource untuk siswa
    Route::resource('/siswa', SiswaController::class);

    // Rute untuk data UID (but protected)
    Route::get('/data-uid', [UIDController::class, 'index'])->name('data-uid');
    Route::post('/uid/update-name', [UIDController::class, 'updateName'])->name('uid.update-name');
    Route::put('/data-uid/{id}/update-student', [UIDController::class, 'updateStudent'])->name('uid.update-student');
});
