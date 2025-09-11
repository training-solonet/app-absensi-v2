<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    // Tentukan koneksi database yang digunakan
    protected $connection = 'absensi_v2';
    
    protected $table = 'absen';
    
    // ... konfigurasi model lainnya
}