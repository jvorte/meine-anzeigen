<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Brand;
use App\Models\ModelCar; // ή όπως ονομάζεται το model σου για τα μοντέλα

class CarModelsTableSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'Volkswagen' => ['Golf', 'Polo', 'Passat'],
            'BMW' => ['3er', '5er', 'X5'],
            'Audi' => ['A3', 'A4', 'Q5'],
        ];

        foreach ($data as $brandName => $models) {
            $brand = Brand::create([
                'name' => $brandName,
                'slug' => Str::slug($brandName),
            ]);

            foreach ($models as $modelName) {
                ModelCar::create([
                    'name' => $modelName,
                    'slug' => Str::slug($modelName),
                    'brand_id' => $brand->id,
                ]);
            }
        }
    }
}
