<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    // Tentukan koneksi database yang digunakan
    protected $connection = 'absensi_v2';

    protected $table = 'absen';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_siswa',
        'tanggal',
        'waktu_masuk',
        'waktu_keluar',
        'keterangan',
        'catatan',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa', 'id');
    }
}
