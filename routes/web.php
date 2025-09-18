<?php

use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\SiswaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UIDController;
use App\Models\Absensi;
use App\Models\Siswa;

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

// Routes yang memerlukan logi
Route::middleware(['web', 'ceklogin'])->group(function () {
    Route::get('/dashboard', function () {
        $terlambat = Absensi::with('siswa')
            ->whereRaw('LOWER(TRIM(keterangan)) = ?', ['terlambat'])
            ->whereDate('tanggal', now())
            ->orderBy('id', 'desc')
            ->limit(10)
            ->get();

        // Summary counters
        $totalSiswa = Siswa::count();
        $hadirHariIni = Absensi::whereDate('tanggal', now())
            ->where(function($q){
                $q->whereRaw('LOWER(TRIM(keterangan)) = ?', ['hadir'])
                  ->orWhereRaw('LOWER(TRIM(keterangan)) = ?', ['terlambat']);
            })
            ->distinct('id_siswa')
            ->count('id_siswa');
        $belumAtauTidakHadir = max($totalSiswa - $hadirHariIni, 0);

        // Realtime stats for donuts (percent of total siswa)
        $izinHariIni = Absensi::whereDate('tanggal', now())
            ->whereRaw('LOWER(TRIM(keterangan)) = ?', ['izin'])
            ->distinct('id_siswa')
            ->count('id_siswa');
        $terlambatOnlyHariIni = Absensi::whereDate('tanggal', now())
            ->whereRaw('LOWER(TRIM(keterangan)) = ?', ['terlambat'])
            ->distinct('id_siswa')
            ->count('id_siswa');
        $hadirTermasukTerlambatHariIni = $hadirHariIni; // already includes terlambat

        $denom = max($totalSiswa, 1);
        $izinPct = round($izinHariIni / $denom * 100);
        $terlambatPct = round($terlambatOnlyHariIni / $denom * 100);
        $hadirPct = round($hadirTermasukTerlambatHariIni / $denom * 100);

        return view('dashboard', compact(
            'terlambat',
            'totalSiswa', 'hadirHariIni', 'belumAtauTidakHadir',
            'izinPct', 'terlambatPct', 'hadirPct'
        ));
    })->name('dashboard');

    // Halaman profil sederhana
    Route::view('/profile', 'profile')->name('profile');

    Route::resource('/siswa', SiswaController::class);
    Route::get('/absensi', [AbsensiController::class, 'index']);
});

Route::get('/data-uid', [UIDController::class, 'index'])->name('data-uid');
