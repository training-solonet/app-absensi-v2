<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;

class AbsensiController extends Controller
{
    public function laporan()
    {
        $absensi = Absensi::with('siswa')->get();
        return view('absensi', compact('absensi.index'));
    }
}
