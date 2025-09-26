<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use Illuminate\Http\Request;
use Carbon\Carbon;

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
}
