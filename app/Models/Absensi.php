<?php

namespace App\Models;

use Dba\Connection;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
  public function index()
    {
        $absen = Absen::all();
        return view('absensi.index', compact('absen'));
    }
}