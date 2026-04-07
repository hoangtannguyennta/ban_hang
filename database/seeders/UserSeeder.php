<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Tạo tài khoản Admin
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Tạo các tài khoản người dùng mẫu
        for ($i = 1; $i <= 5; $i++) {
            User::create([
                'name' => "Người dùng mẫu $i",
                'email' => "user$i@gmail.com",
                'password' => Hash::make('password'),
                'role' => 'user',
            ]);
        }
    }
}