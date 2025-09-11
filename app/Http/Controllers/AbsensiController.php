<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AbsensiController extends Controller
{
    public function index()
    {
        $absen = DB::connection('absensi_v2')->table('absen')->get();
        
        return view('absensi', compact('absen'));
    }
}