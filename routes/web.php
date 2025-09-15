<?php

use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\SiswaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Redirect root ke login
Route::get('/', function () {
    return redirect('/login');
});

// Halaman login
Route::view('/login', 'login')->name('login');

// Proses Login
Route::post('/proses-login', function (Request $request) {
    $email = $request->input('email');
    $password = $request->input('password');

    if ($email === 'admin@gmail.com' && $password === '123456') {
        // Set session untuk menandai user sudah login
        session(['user_logged_in' => true, 'user_email' => $email]);

        return redirect('/dashboard');
    }

    return back()->with('error', 'Email atau Password salah!');
})->name('prosesLogin');

// Logout
Route::post('/logout', function () {
    session()->flush();

    return redirect('/login')->with('success', 'Berhasil logout!');
})->name('logout');

// Routes yang memerlukan login
Route::middleware(['web', 'ceklogin'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Halaman profil sederhana
    Route::view('/profile', 'profile')->name('profile');

    Route::resource('/siswa', SiswaController::class);
    Route::get('/absensi', [AbsensiController::class, 'index']);
});
