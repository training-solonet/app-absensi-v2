<?php

namespace App\Models;

use App\Models\Siswa;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    // Tentukan koneksi database yang digunakan
    protected $connection = 'absensi_v2';

    protected $table = 'absen';

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa', 'id');
    }
}
