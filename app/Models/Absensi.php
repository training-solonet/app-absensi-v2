<?php

namespace App\Models;

use Dba\Connection;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
protected $Connection='absensi_v2';
    protected $absen = 'view_absen'; 
    public $timestamps = false; 

    protected $fillable = [
        'id_siswa',
        'tanggal',
        'waktu_masuk',
        'waktu_keluar',
        'keterangan',
        'catatan',
    ];
}
