<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AbsensiController extends Controller
{
    public function index(Request $request)
    {
        $dateParam = $request->query('tanggal');
        $selectedDate = $dateParam ? Carbon::parse($dateParam)->startOfDay() : Carbon::today();

        // Data absensi untuk tanggal terpilih
        $absen = Absensi::with('siswa')
            ->whereDate('tanggal', $selectedDate)
            ->orderBy('id', 'desc')
            ->get();

        // Hitung statistik hari sebelumnya dari tanggal yang dipilih
        $prevDate = (clone $selectedDate)->subDay();

        $hadirKemarin = Absensi::whereDate('tanggal', $prevDate)
            ->whereRaw('LOWER(TRIM(keterangan)) = ?', ['hadir'])
            ->distinct('id_siswa')
            ->count('id_siswa');

        $terlambatKemarin = Absensi::whereDate('tanggal', $prevDate)
            ->whereRaw('LOWER(TRIM(keterangan)) = ?', ['terlambat'])
            ->distinct('id_siswa')
            ->count('id_siswa');

        return view('absensi', compact('absen', 'selectedDate', 'hadirKemarin', 'terlambatKemarin'));
    }

    public function terlambat(Request $request)
    {
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
                $q->whereRaw('LOWER(TRIM(keterangan)) = ?', ['hadir'])
                    ->orWhereRaw('LOWER(TRIM(keterangan)) = ?', ['terlambat']);
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

        $selectedYear = now()->year;
        $selectedMonth = (int) ($request->query('month', now()->month));

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

        $terlambatPerSiswa = Absensi::with('siswa')
            ->selectRaw('id_siswa, COUNT(*) as total')
            ->whereYear('tanggal', $selectedYear)
            ->whereMonth('tanggal', $selectedMonth)
            ->whereRaw('LOWER(TRIM(keterangan)) = ?', ['terlambat'])
            ->groupBy('id_siswa')
            ->orderByDesc('total')
            ->get();

        // Data kehadiran siswa untuk bulan terpilih
        $absensiBulanIni = Absensi::with('siswa')
            ->selectRaw('id_siswa, COUNT(*) as total_hadir')
            ->whereYear('tanggal', $selectedYear)
            ->whereMonth('tanggal', $selectedMonth)
            ->where(function ($query) {
                $query->whereRaw('LOWER(TRIM(keterangan)) = ?', ['hadir'])
                    ->orWhereRaw('LOWER(TRIM(keterangan)) = ?', ['terlambat']);
            })
            ->groupBy('id_siswa')
            ->orderBy('total_hadir', 'desc')
            ->get();

        // Opsi bulan (1..12)
        $monthOptions = range(1, 12);

        return view('absensi', compact(
            'terlambat',
            'terlambatPerSiswa',
            'absensiBulanIni',
            'totalSiswa',
            'hadirHariIni',
            'belumAtauTidakHadir',
            'izinPct',
            'terlambatPct',
            'hadirPct',
            'terlambatPerBulanPct',
            'terlambatPerBulanCount',
            'selectedYear',
            'selectedMonth',
            'monthOptions'
        ));
    }
}
