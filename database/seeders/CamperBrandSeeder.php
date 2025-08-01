<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CamperBrand; // Make sure to import

class CamperBrandSeeder extends Seeder
{
    public function run(): void
    {
        CamperBrand::create(['name' => 'Adria', 'slug' => 'adria']); // ID 1 (or whatever the auto-increment is)
        CamperBrand::create(['name' => 'Bürstner', 'slug' => 'burstner']); // ID 2
        CamperBrand::create(['name' => 'Dethleffs', 'slug' => 'dethleffs']); // ID 3
        CamperBrand::create(['name' => 'Hymer', 'slug' => 'hymer']); // ID 4
        CamperBrand::create(['name' => 'Knaus', 'slug' => 'knaus']); // ID 5
        CamperBrand::create(['name' => 'Sunlight', 'slug' => 'sunlight']); // ID 6
        CamperBrand::create(['name' => 'Weinsberg', 'slug' => 'weinsberg']); // ID 7
        CamperBrand::create(['name' => 'Pilote', 'slug' => 'pilote']); // ID 8 (This one is important as you tested with ID 8)
        CamperBrand::create(['name' => 'Challenger', 'slug' => 'challenger']); // ID 9
        // ... add more brands as needed
    }
}