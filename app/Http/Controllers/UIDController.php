<?php

namespace App\Http\Controllers;

use App\Models\Uid;

class UIDController extends Controller
{
    public function index()
    {
        // Load UID records and eager-load only the fields needed from Siswa
        // so we can show the student's name instead of an ID in the table
        $uids = Uid::with(['siswa:id,name'])->get();

        return view('datauid', compact('uids'));
    }
}
