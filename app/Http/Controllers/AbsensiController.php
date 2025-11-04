<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use Illuminate\Http\Request;

class AbsensiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $selectedDate = request('tanggal', date('Y-m-d'));

        /** @var \Illuminate\Database\Eloquent\Collection<array-key, Absensi> $absen */
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

        // Type casting untuk memastikan view-string yang valid
        /** @var view-string $viewName */
        $viewName = 'absensi';

        return view($viewName, compact('absen', 'selectedDate', 'hadirKemarin', 'terlambatKemarin'));
    }

    public function terlambat()
    {
        $selectedDate = request('tanggal', date('Y-m-d'));

        $absen = Absensi::with('siswa')
            ->whereDate('tanggal', $selectedDate)
            ->where('keterangan', 'terlambat')
            ->orderBy('tanggal', 'desc')
            ->get();

        /** @var view-string $viewName */
        $viewName = 'absensi-terlambat';

        return view($viewName, compact('absen', 'selectedDate'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'keterangan' => 'required|in:Hadir,Izin,Sakit',
            'catatan' => 'nullable|string|max:255',
        ]);

        /** @var Absensi $absensi */
        $absensi = Absensi::findOrFail($id);

        $updates = [
            'keterangan' => $validated['keterangan'],
            'updated_at' => now(),
        ];

        if (isset($validated['catatan'])) {
            $updates['catatan'] = $validated['catatan'];
        }

        if ($validated['keterangan'] === 'Hadir' && empty($absensi->getAttribute('waktu_masuk'))) {
            $updates['waktu_masuk'] = now()->format('H:i:s');
        }

        $absensi->update($updates);

        return back()->with('success', 'Status absensi berhasil diperbarui');
    }
}
