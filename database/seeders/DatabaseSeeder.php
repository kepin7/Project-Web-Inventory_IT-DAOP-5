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
        // Kategori Real (ID 1 sampai 7)
        $categories = [
            ['id' => 1, 'name' => 'CPU', 'icon' => 'Cpu'],
            ['id' => 2, 'name' => 'MONITOR', 'icon' => 'Monitor'],
            ['id' => 3, 'name' => 'PRINTER', 'icon' => 'Printer'],
            ['id' => 4, 'name' => 'SWITCH', 'icon' => 'Server'],
            ['id' => 5, 'name' => 'UPS', 'icon' => 'Battery'],
            ['id' => 6, 'name' => 'AIO', 'icon' => 'Monitor'],
            ['id' => 7, 'name' => 'DRIVE', 'icon' => 'HardDrive'],
        ];

        foreach ($categories as $cat) {
            \App\Models\Category::firstOrCreate(
                ['id' => $cat['id']],
                ['name' => $cat['name'], 'icon' => $cat['icon']]
            );
        }

        // Lokasi Real (ID 1)
        \App\Models\Location::firstOrCreate(
            ['id' => 1],
            ['name' => 'GUDANG IT', 'description' => 'Gudang utama IT DAOP 5', 'capacity' => 1000]
        );
    }
}


