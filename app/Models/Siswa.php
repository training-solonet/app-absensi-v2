<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'siswa'; // sesuaikan dengan nama tabel

    protected $fillable = [
        'name',
        'id_card',
    ];

    public function up(): void
{
    Schema::table('siswa', function (Blueprint $table) {
        $table->string('kelas')->nullable();
        $table->string('jurusan')->nullable();
    });
}

public function down(): void
{
    Schema::table('siswa', function (Blueprint $table) {
        $table->dropColumn(['kelas', 'jurusan']);
    });
}

}
