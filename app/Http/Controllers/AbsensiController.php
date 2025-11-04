<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use Illuminate\Http\Request;

class AbsensiController extends Controller
{
    public function index()
    {
        $selectedDate = request('tanggal', date('Y-m-d'));

        $absen = Absensi::with('siswa')
            ->whereDate('tanggal', $selectedDate)
            ->orderBy('tanggal', 'desc')
            ->get();

        // Hitung jumlah hadir dan terlambat
        $hadirKemarin = Absensi::whereDate('tanggal', now()->subDay())
            ->where('keterangan', 'hadir')
            ->count();

        $terlambatKemarin = Absensi::whereDate('tanggal', now()->subDay())
            ->where('keterangan', 'terlambat')
            ->count();

        return view('absensi', compact('absen', 'selectedDate', 'hadirKemarin', 'terlambatKemarin'));
    }

    public function terlambat()
    {
        $selectedDate = request('tanggal', date('Y-m-d'));

        $absen = Absensi::with('siswa')
            ->whereDate('tanggal', $selectedDate)
            ->where('keterangan', 'terlambat')
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('absensi-terlambat', compact('absen', 'selectedDate'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'keterangan' => 'required|in:Hadir,Izin,Sakit',
        ]);

        $absensi = Absensi::findOrFail($id);

        // Jika status diubah menjadi Hadir, set waktu_masuk jika belum ada
        $updates = [
            'keterangan' => $validated['keterangan'],
            'updated_at' => now(),
        ];

        if ($validated['keterangan'] === 'Hadir' && ! $absensi->waktu_masuk) {
            $updates['waktu_masuk'] = now()->format('H:i:s');
        }

        $absensi->update($updates);

        return back()->with('success', 'Status absensi berhasil diperbarui');
    }
}
