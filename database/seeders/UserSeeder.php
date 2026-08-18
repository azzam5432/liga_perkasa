<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@example.com',
            'password' => Hash::make('password123'),
            'role' => 'super_admin',
            'no_telp' => '08123456789',
            'jabatan' => 'Super Administrator',
            'bio' => 'Super Admin of the system',
        ]);

        User::create([
            'name' => 'Panitia 1',
            'email' => 'panitia@example.com',
            'password' => Hash::make('password123'),
            'role' => 'panitia',
            'no_telp' => '08123456788',
            'jabatan' => 'Ketua Panitia',
            'instagram' => 'https://instagram.com/panitia1',
            'facebook' => 'https://facebook.com/panitia1',
            'bio' => 'Saya adalah panitia yang bertanggung jawab',
        ]);
    }
}