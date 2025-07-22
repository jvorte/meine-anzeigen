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
            CategorySeeder::class,
        ]);
        $this->call([
            // CarModelsTableSeeder::class,
        ]);
        
    $this->call([
            // Ensure BrandSeeder is called first as others depend on it
            BrandSeeder::class,
            CategorySeeder::class, // Call CategorySeeder if you have it
    
            ElectronicModelSeeder::class, // Call this if you have it, it depends on BrandSeeder
            // Add any other seeders here that you want to run
        ]);
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
