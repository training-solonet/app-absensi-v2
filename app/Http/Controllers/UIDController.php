<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Uid;

class UIDController extends Controller
{
    public function index()
    {
        
        $uids = Uid::with('siswa')->get();
        return view('datauid', compact('uids'));

    }
}
