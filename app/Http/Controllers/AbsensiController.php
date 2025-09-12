<?php

namespace App\Http\Controllers;

use App\Models\Absensi;

class AbsensiController extends Controller
{
    public function index()
    {
        $absen = Absensi::with('siswa')->orderBy('id', 'desc')->limit(10)->get();

        return view('absensi', compact('absen'));
    }
}
