<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Akun admin utama
        $admin = User::updateOrCreate(
            ['email' => 'admin@connectis.my.id'],
            [
                'name' => 'Admin Connectis',
                'password' => Hash::make('connectis123'),
                'email_verified_at' => now(),
            ]
        );
        
        $this->command->info('User created/updated: ' . $admin->email);
        $this->command->info('Password: connectis123');
        
        // Akun tambahan untuk testing
        $testUsers = [
            [
                'name' => 'Manager',
                'email' => 'manager@connectis.my.id',
                'password' => 'manager123'
            ],
            [
                'name' => 'Staff',
                'email' => 'staff@connectis.my.id',
                'password' => 'staff123'
            ]
        ];
        
        foreach ($testUsers as $user) {
            $newUser = User::updateOrCreate(
                ['email' => $user['email']],
                [
                    'name' => $user['name'],
                    'password' => Hash::make($user['password']),
                    'email_verified_at' => now(),
                ]
            );
            
            $this->command->info('User created/updated: ' . $newUser->email);
            $this->command->info('Password: ' . $user['password']);
        }
    }
}
