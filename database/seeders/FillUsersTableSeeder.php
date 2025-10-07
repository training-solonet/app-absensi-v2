<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class FillUsersTableSeeder extends Seeder
{
    public function run(): void
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
