<?php

namespace App\Http\Controllers;

use App\Models\Siswa;

class SiswaController extends Controller
{
    // Tampilkan halaman Data Siswa
    public function index()
    {
        // Ambil semua data siswa dari database
        $siswas = Siswa::all();

        // Kirim data ke view resources/views/siswa/index.blade.php
        return view('siswa', compact('siswas'));

    }
}
