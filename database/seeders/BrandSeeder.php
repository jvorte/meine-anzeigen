<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Brand;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brands = [
            'Honda', 'Yamaha', 'Kawasaki', 'BMW', 'Ducati', 'Harley-Davidson',
            'Mercedes-Benz', 'Ford', 'Volkswagen', 'Volvo', 'Scania', 'MAN',
            'Hymer', 'Fendt', 'Knaus', 'Dethleffs',
            'Apple', 'Samsung', 'Sony', 'LG', 'Bosch', 'Siemens', 'Philips',
            'Bavaria', 'Jeanneau', 'Sea Ray', 'Beneteau',
        ];

        foreach ($brands as $brandName) {
            Brand::firstOrCreate(['name' => $brandName]);
        }
    }
}
