<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $table = 'view_siswa'; // pakai view, bukan tabel siswas
    public $timestamps = false; // kalau view tidak ada created_at & updated_at
}
