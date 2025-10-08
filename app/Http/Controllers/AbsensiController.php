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

        $absen = Absensi::with('siswa')
            ->whereDate('tanggal', $selectedDate)
            ->orderBy('id', 'desc')
            ->get();

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

    public function update(Request $request, Absensi $absensi)
    {
        $validated = $request->validate([
            'keterangan' => 'required|in:Izin,Sakit',
        ]);

        $absensi->update([
            'keterangan' => $validated['keterangan'],
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Status absensi berhasil diperbarui');
    }
}
