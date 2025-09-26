<?php

use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\UIDController;
use App\Models\Absensi;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Route::view('/login', 'login')->name('login');

Route::post('/proses-login', function (Request $request) {
    $email = $request->input('email');
    $password = $request->input('password');

    if ($email === 'admin@gmail.com' && $password === '123456') {
        session(['user_logged_in' => true, 'user_email' => $email]);

        return redirect('/profile');
    }

    return back()->with('error', 'Email atau Password salah!');
})->name('prosesLogin');

// Logout
Route::post('/logout', function () {
    session()->flush();

    return redirect('/login')->with('success', 'Berhasil logout!');
})->name('logout');

    Route::middleware(['web', 'ceklogin'])->group(function () {
        Route::get('/dashboard', function (Request $request) {
            $terlambat = Absensi::with('siswa')
                ->whereRaw('LOWER(TRIM(keterangan)) = ?', ['terlambat'])
                ->whereDate('tanggal', now())
                ->orderBy('id', 'desc')
                ->limit(10)
                ->get();

        // Summary counters
        $totalSiswa = Siswa::count();
        $hadirHariIni = Absensi::whereDate('tanggal', now())
            ->where(function ($q) {
                $q->whereRaw('LOWER(TRIM(keterangan)) = ?', ['hadir']);
                $q->orWhereRaw('LOWER(TRIM(keterangan)) = ?', ['terlambat']);
            })
            ->distinct('id_siswa')
            ->count('id_siswa');
        $belumAtauTidakHadir = max($totalSiswa - $hadirHariIni, 0);

        $izinHariIni = Absensi::whereDate('tanggal', now())
            ->whereRaw('LOWER(TRIM(keterangan)) = ?', ['izin'])
            ->distinct('id_siswa')
            ->count('id_siswa');
        $terlambatOnlyHariIni = Absensi::whereDate('tanggal', now())
            ->whereRaw('LOWER(TRIM(keterangan)) = ?', ['terlambat'])
            ->distinct('id_siswa')
            ->count('id_siswa');
        $hadirTermasukTerlambatHariIni = $hadirHariIni;

        $denom = max($totalSiswa, 1);
        $izinPct = round($izinHariIni / $denom * 100);
        $terlambatPct = round($terlambatOnlyHariIni / $denom * 100);
        $hadirPct = round($hadirTermasukTerlambatHariIni / $denom * 100);

        // Hitung persentase & jumlah terlambat per bulan (real-time) untuk tahun terpilih
        $selectedYear = (int) ($request->query('year', now()->year));
        $terlambatPerBulanPct = [];
        $terlambatPerBulanCount = [];
        for ($bulan = 1; $bulan <= 12; $bulan++) {
            $jumlahTerlambatUnik = Absensi::whereYear('tanggal', $selectedYear)
                ->whereMonth('tanggal', $bulan)
                ->whereRaw('LOWER(TRIM(keterangan)) = ?', ['terlambat'])
                ->distinct('id_siswa')
                ->count('id_siswa');

            $pct = round(($jumlahTerlambatUnik / max($totalSiswa, 1)) * 100, 2);
            $terlambatPerBulanPct[] = $pct;
            $terlambatPerBulanCount[] = $jumlahTerlambatUnik;
        }

        // Opsi tahun untuk dropdown (5 tahun terakhir hingga tahun berjalan)
        $currentYear = now()->year;
        $yearOptions = range($currentYear - 4, $currentYear);

            return view('dashboard', compact(
                'terlambat',
                'totalSiswa', 'hadirHariIni', 'belumAtauTidakHadir',
                'izinPct', 'terlambatPct', 'hadirPct',
                'terlambatPerBulanPct', 'terlambatPerBulanCount',
                'selectedYear', 'yearOptions'
            ));
        })->name('dashboard');

    Route::view('/profile', 'profile')->name('profile');

    Route::resource('/siswa', SiswaController::class);
    Route::get('/absensi', [AbsensiController::class, 'index']);
});

Route::get('/data-uid', [UIDController::class, 'index'])->name('data-uid');

// AJAX: update nama UID
Route::post('/uid/update-name', [UIDController::class, 'updateName'])->name('uid.update-name');
