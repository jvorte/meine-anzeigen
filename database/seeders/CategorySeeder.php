<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['name' => 'Fahrzeuge', 'slug' => 'fahrzeuge'],
            ['name' => 'Fahrzeugeteile', 'slug' => 'fahrzeugeteile'],
               ['name' => 'Boote', 'slug' => 'boote'],
            ['name' => 'Elektronik', 'slug' => 'elektronik'],
            ['name' => 'Haushalt', 'slug' => 'haushalt'],
            ['name' => 'Immobilien', 'slug' => 'immobilien'],
            ['name' => 'Dienstleistungen', 'slug' => 'dienstleistungen'],
             ['name' => 'Sonstiges', 'slug' => 'sonstiges'],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['slug' => $category['slug']],
                ['name' => $category['name']]
            );
        }

        
    }
}
