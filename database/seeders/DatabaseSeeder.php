<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Akun Super Admin Utama
        // Login melalui Magic Link menggunakan email ini
        $superAdminEmail = 'M.sugianto62537@gmail.com';

        User::firstOrCreate(
            ['email' => $superAdminEmail],
            [
                'name' => 'Super Administrator',
                'role' => 'super_admin',
                'is_active' => true,
            ]
        );

        // Akun Super Admin Hizkia Kevin
        // Login melalui Magic Link menggunakan email ini
        $hizkiaEmail = 'hizkiakevin8@gmail.com';

        User::firstOrCreate(
            ['email' => $hizkiaEmail],
            [
                'name' => 'Hizkia Kevin',
                'role' => 'super_admin',
                'is_active' => true,
            ]
        );
    }
}
