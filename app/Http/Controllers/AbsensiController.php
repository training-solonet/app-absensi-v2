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
        $startParam = $request->query('tanggal_awal');
        $endParam = $request->query('tanggal_akhir');

        // Default selectedDate used for UI when single-date view
        $selectedDate = $dateParam ? Carbon::parse($dateParam)->startOfDay() : Carbon::today();

        // If a date range is provided, return all records in that inclusive range
        if ($startParam || $endParam) {
            try {
                $start = $startParam ? Carbon::parse($startParam)->startOfDay() : null;
                $end = $endParam ? Carbon::parse($endParam)->endOfDay() : null;
            } catch (\Exception $e) {
                // fallback to selectedDate if parsing fails
                $start = $selectedDate->startOfDay();
                $end = $selectedDate->endOfDay();
            }

            $query = Absensi::with('siswa')->orderBy('id', 'desc');
            if ($start && $end) {
                $query->whereBetween('tanggal', [$start, $end]);
            } elseif ($start) {
                $query->whereDate('tanggal', $start);
            } elseif ($end) {
                $query->whereDate('tanggal', $end);
            }

            $absen = $query->get();
        } else {
            // single-date behavior (existing)
            $absen = Absensi::with('siswa')
                ->whereDate('tanggal', $selectedDate)
                ->orderBy('id', 'desc')
                ->get();
        }

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

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'keterangan' => 'required|in:Izin,Sakit',
        ]);

        $absensi = Absensi::findOrFail($id);
        $absensi->update([
            'keterangan' => $validated['keterangan'],
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Status absensi berhasil diperbarui');
    }
}
