<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CamperBrand;
use Illuminate\Support\Str; // <-- Added this line

class CamperBrandSeeder extends Seeder
{
    public function run(): void
    {
        $brands = [
            'Fiat', 'Ford', 'Mercedes-Benz', 'Renault', 'Volkswagen',
            'Hymer', 'Dethleffs', 'Bürstner', 'Knaus', 'LMC', 'Carthago', 'Frankia', 'Eura Mobil', 'Hobby', 'Sunlight',
            'Pilote', 'Challenger', 'Benimar', 'Rapido', 'Chausson', 'Fleurette',
            'Adria', 'Laika', 'Rimor', 'Mobilvetta',
            'Bailey', 'Swift', 'Elddis',
            'Forest River', 'Thor Motor Coach', 'Jayco', 'Winnebago',
            'Weinsberg', 'Niesmann + Bischoff', 'Carado', 'Morelo', 'Globecar', 'Pössl', 'Westfalia', 'Eriba', 'Vantourer',
            'Other',
        ];

        foreach ($brands as $brandName) {
            CamperBrand::firstOrCreate([
                'name' => $brandName,
                'slug' => Str::slug($brandName), // <-- Updated this line
            ]);
        }
    }
}