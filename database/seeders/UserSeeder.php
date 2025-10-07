<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@connectis.my.id'], 
            [
                'name' => 'Admin Connectis',
                'password' => Hash::make('connectis123'),
            ]
        );
    }
}
