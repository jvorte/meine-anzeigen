<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // Import DB facade

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing categories to prevent duplicates on re-seed
        DB::table('categories')->truncate(); // Use truncate if safe, or delete()

        $categories = [
            ['name' => 'Fahrzeuge', 'slug' => 'fahrzeuge'],
            ['name' => 'Fahrzeugeteile', 'slug' => 'fahrzeugeteile'],
            ['name' => 'Boote', 'slug' => 'boote'],
            ['name' => 'Elektronik', 'slug' => 'elektronik'],
            ['name' => 'Haushalt', 'slug' => 'haushalt'],
            ['name' => 'Immobilien', 'slug' => 'immobilien'],
            ['name' => 'Dienstleistungen', 'slug' => 'dienstleistungen'],
            ['name' => 'Sonstiges', 'slug' => 'sonstiges'],
            ['name' => 'Motorräder', 'slug' => 'motorrad'],
            ['name' => 'Nutzfahrzeuge', 'slug' => 'nutzfahrzeuge'],
            ['name' => 'Wohnmobile', 'slug' => 'wohnmobile'],
        ];

        foreach ($categories as $category) {
            DB::table('categories')->insert([
                'name' => $category['name'],
                'slug' => $category['slug'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}