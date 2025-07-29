<?php

namespace Database\Seeders;

use App\Models\User;

use Illuminate\Database\Seeder;
use Database\Seeders\ElectronicBrandSeeder; // Make sure this is imported


class DatabaseSeeder extends Seeder
{

    /**
     * Seed the application's database.
     */
    public function run(): void
    {

         $this->call([
            CategoryTableSeeder::class,
             ElectronicBrandSeeder::class, 
        ]);
  
        
 

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
