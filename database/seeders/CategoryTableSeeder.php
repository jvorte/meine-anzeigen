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
            ['name' => 'Cars', 'slug' => 'cars'],
            ['name' => 'Vehicles-parts', 'slug' => 'vehicles-parts'],
            ['name' => 'Boats', 'slug' => 'boats'],
            ['name' => 'Electronics', 'slug' => 'electronics'],
            ['name' => 'Household', 'slug' => 'household'],
            ['name' => 'Real Estate', 'slug' => 'real-estate'],
            ['name' => 'Services', 'slug' => 'services'],
            ['name' => 'Sonstiges', 'slug' => 'sonstiges'],
            ['name' => 'Motorcycles', 'slug' => 'motorcycles'],
            ['name' => 'Commercial-vehicle', 'slug' => 'commercial-vehicle'],
            ['name' => 'Campers', 'slug' => 'campers'],
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
