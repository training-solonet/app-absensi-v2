<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Siswa;

class SiswaSeeder extends Seeder
{
    public function run(): void
    {
        Siswa::create(['nama' => 'Budi Santoso', 'kelas' => 'XII RPL 1', 'jurusan' => 'RPL']);
        Siswa::create(['nama' => 'Ani Lestari', 'kelas' => 'XII TKJ 2', 'jurusan' => 'TKJ']);
    }
}
