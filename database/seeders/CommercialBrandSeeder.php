<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CommercialBrand; // Don't forget to import your model

class CommercialBrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brands = [
            'Volkswagen',
            'Mercedes-Benz',
            'Ford',
            'Renault',
            'Peugeot',
            'Citroën',
            'Opel',
            'Toyota',
            'Fiat',
            'Hyundai',
            'Nissan',
            'Iveco',
            // Add more brands as needed
        ];

        foreach ($brands as $brandName) {
            CommercialBrand::firstOrCreate(['name' => $brandName]);
        }
    }
}