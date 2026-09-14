<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Location;
use App\Models\SparePart;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

#[Signature('app:import-pdf-data')]
#[Description('Command description')]
class ImportPdfData extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $path = storage_path('app/parsed_data.json');
        if (!File::exists($path)) {
            $this->error('File not found at ' . $path);
            return;
        }

        // Disable foreign key checks for truncation
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        SparePart::truncate();
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $data = json_decode(File::get($path), true);
        
        $defaultLocation = Location::firstOrCreate(['name' => 'GUDANG IT'], ['status' => 'aktif']);
        
        $categoryCache = [];

        foreach ($data as $item) {
            $catName = $item['category'];
            if (!isset($categoryCache[$catName])) {
                $categoryCache[$catName] = Category::firstOrCreate(['name' => $catName], ['status' => 'aktif'])->id;
            }

            SparePart::create([
                'brand' => $item['brand'],
                'type' => $item['type'],
                'serial_number' => $item['serial_number'],
                'inventory_number' => $item['inventory_number'],
                'description' => $item['description'],
                'condition' => $item['condition'],
                'location_id' => $defaultLocation->id,
                'category_id' => $categoryCache[$catName],
            ]);
        }

        $this->info('Successfully imported ' . count($data) . ' spare parts!');
    }
}
