<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Absensi;
use App\Models\Siswa;

class AbsensiController extends Controller
{
    public function index()
    {
        $absen = Absensi::with('siswa')->orderBy('id','desc')->limit(10)->get();

        return view('absensi', compact('absen'));
    }
}