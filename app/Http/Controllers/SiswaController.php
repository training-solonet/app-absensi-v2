<?php

namespace App\Http\Controllers;

use App\Models\Siswa;

class SiswaController extends Controller
{
    // Tampilkan halaman Data Siswa
    public function index()
    {
        $siswas = Siswa::all();
        return view('siswa', compact('siswas'));

    }
}
