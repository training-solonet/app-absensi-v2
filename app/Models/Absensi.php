<?php

namespace App\Models;

use Dba\Connection;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
protected $Connection='absensi_v2';
    protected $table = 'absen'; // nama tabel di DB
    protected $primaryKey = 'id';
    public $timestamps = false; // kalau tabel tidak ada kolom created_at & updated_at

    protected $fillable = [
        'id_siswa',
        'tanggal',
        'waktu_masuk',
        'waktu_keluar',
        'keterangan',
        'catatan',
    ];
}
