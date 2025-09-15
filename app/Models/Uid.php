<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Uid extends Model
{
    protected $connection = 'absensi_v2';

    protected $table = 'uid'; 

    protected $fillable = ['uid', 'name'];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa', 'id');
    }
}
