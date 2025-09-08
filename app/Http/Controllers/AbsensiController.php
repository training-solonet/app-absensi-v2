<?php

namespace App\Http\Controllers;
use App\Models\Absensi;

class AbsensiController extends Controller
{
      public function index()
    {
        $absen = Absen::all();

        return view('absensi.index', compact('absen'));
    }
}
