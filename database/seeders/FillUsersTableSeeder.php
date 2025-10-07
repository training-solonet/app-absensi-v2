<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class FillUsersTableSeeder extends Seeder
{public function run(): void
    {
        $users = [
            [
                'name' => 'Admin Connectis',
                'email' => 'admin@connectis.my.id',
                'password' => bcrypt('connectis123'),  // Pastikan menggunakan bcrypt
                'email_verified_at' => now(),
            ],
        ];
    
        foreach ($users as $user) {
            \App\Models\User::updateOrCreate(
                ['email' => $user['email']],
                $user
            );
        }
    }
}