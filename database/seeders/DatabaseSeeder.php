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
        $superAdminEmail = 'hizkiakevin8@gmail.com'; // Ganti email ini dengan email Anda

        User::firstOrCreate(
            ['email' => $superAdminEmail],
            [
                'name' => 'Super Administrator',
                'role' => 'super_admin',
                'is_active' => true,
            ]
        );
    }
}


