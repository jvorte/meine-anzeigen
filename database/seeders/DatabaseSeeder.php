<?php

namespace Database\Seeders;

use App\Models\User;

use Illuminate\Database\Seeder;
use Database\Seeders\BrandSeeder; // Make sure this is imported
use Database\Seeders\CarModelSeeder; // If you have this
use Database\Seeders\ElectronicModelSeeder; // If you have this
use Database\Seeders\CategorySeeder; // I

class DatabaseSeeder extends Seeder
{

    /**
     * Seed the application's database.
     */
    public function run(): void
    {

         $this->call([
            CategoryTableSeeder::class,
            // Add other seeders here, e.g., BrandSeeder::class if you fix it
        ]);
  
        
  

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
