<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property-read Siswa $siswa
*/

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
