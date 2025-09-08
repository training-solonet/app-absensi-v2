<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $connection ='siswa_connectis';
    protected $table = 'view_siswa'; 
    public $timestamps = false; 
}
