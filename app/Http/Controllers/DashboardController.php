<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Siswa;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $selectedMonth = $request->get('month', date('m'));
        $currentMonth = (int) $selectedMonth;
        $year = date('Y');

        // Get all active students
        $siswaAktif = Siswa::pluck('id');

        // Hitung total siswa aktif
        $totalSiswa = $siswaAktif->count();

        // Hitung kehadiran hari ini untuk siswa aktif
        $hadirHariIni = Absensi::whereIn('id_siswa', $siswaAktif)
            ->whereDate('tanggal', now())
            ->where('keterangan', 'hadir')
            ->count();

        // Hitung yang belum/tidak hadir
        $belumAtauTidakHadir = $totalSiswa - $hadirHariIni;

        // Data absensi bulan ini untuk siswa aktif
        $absensiBulanIni = Absensi::with('siswa')
            ->selectRaw('id_siswa, COUNT(*) as total_hadir')
            ->whereIn('id_siswa', $siswaAktif)
            ->whereMonth('tanggal', $currentMonth)
            ->where('keterangan', 'hadir')
            ->groupBy('id_siswa')
            ->orderBy('total_hadir', 'desc')
            ->get();

        // Data terlambat (untuk card bawah) - difilter berdasarkan bulan yang dipilih
        $terlambat = Absensi::with('siswa')
            ->whereIn('id_siswa', $siswaAktif)
            ->where('keterangan', 'terlambat')
            ->whereMonth('tanggal', $currentMonth)
            ->whereYear('tanggal', $year)
            ->orderBy('tanggal', 'desc')
            ->take(6)
            ->get();

        // Data terlambat per siswa untuk bulan yang dipilih
        $terlambatPerSiswa = Absensi::with('siswa')
            ->selectRaw('id_siswa, COUNT(*) as total')
            ->whereIn('id_siswa', $siswaAktif)
            ->whereMonth('tanggal', $currentMonth)
            ->whereYear('tanggal', $year)
            ->where('keterangan', 'terlambat')
            ->groupBy('id_siswa')
            ->orderBy('total', 'desc')
            ->get();

        // Total keterlambatan bulan ini
        $totalTerlambat = $terlambatPerSiswa->sum('total');

        // Total terlambat bulan ini
        $totalTerlambatBulanIni = $terlambatPerSiswa->sum('total');

        // Data statistik kehadiran per bulan untuk grafik
        $statistikBulanan = [];
        for ($i = 1; $i <= 12; $i++) {
            $hadir = Absensi::whereIn('id_siswa', $siswaAktif)
                ->whereMonth('tanggal', $i)
                ->whereYear('tanggal', $year)
                ->where('keterangan', 'hadir')
                ->count();

            $terlambatCount = Absensi::whereIn('id_siswa', $siswaAktif)
                ->whereMonth('tanggal', $i)
                ->whereYear('tanggal', $year)
                ->where('keterangan', 'terlambat')
                ->count();

            $statistikBulanan[] = [
                'bulan' => date('M', mktime(0, 0, 0, $i, 10)),
                'hadir' => $hadir,
                'terlambat' => $terlambatCount,
            ];
        }

        // Bulan-bulan untuk dropdown
        $fullMonthNames = [
            1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember',
        ];

        return view('dashboard', compact(
            'totalSiswa',
            'hadirHariIni',
            'belumAtauTidakHadir',
            'absensiBulanIni',
            'terlambat',
            'terlambatPerSiswa',
            'fullMonthNames',
            'selectedMonth',
            'statistikBulanan',
            'year'
        ));
    }
}
