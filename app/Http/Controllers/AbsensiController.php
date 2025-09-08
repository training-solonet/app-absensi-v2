<?php

namespace App\Http\Controllers;

use App\Models\Absensi;

class AbsensiController extends Controller
{
    public function index()
    {
        // ambil semua data absen
        $data = Absensi::all();

        // kirim ke view
        return view('absensi', compact('absen'));
    }
}
