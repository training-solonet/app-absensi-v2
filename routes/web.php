<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::view('/login', 'login')->name('login.show');

// Proses Login
Route::post('/proses-login', function (Request $request) {
    $email = $request->input('email');
    $password = $request->input('password');

    if ($email === 'admin@gmail.com' && $password === '123456') {
        return redirect()->route('dashboard');
    }

    return back()->with('error', 'Email atau Password salah!');
})->name('prosesLogin');

// Dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

// Data Siswa
use App\Http\Controllers\SiswaController;

Route::get('/siswa', [SiswaController::class, 'index'])->name('siswa.index');
Route::post('/siswa', [SiswaController::class, 'store'])->name('siswa.store');

//lapooran absensi
use App\Http\Controllers\AbsensiController;

Route::get('/absensi', [AbsensiController::class, 'index']);





