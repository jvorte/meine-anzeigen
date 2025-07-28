<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Brand;
use App\Models\ElectronicModel;

class ElectronicModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $apple = Brand::firstOrCreate(['name' => 'Apple']);
        $samsung = Brand::firstOrCreate(['name' => 'Samsung']);
        $sony = Brand::firstOrCreate(['name' => 'Sony']);
        $lg = Brand::firstOrCreate(['name' => 'LG']);
        $bosch = Brand::firstOrCreate(['name' => 'Bosch']);

        if ($apple) {
            $apple->electronicModels()->firstOrCreate(['name' => 'iPhone 15 Pro', 'category_hint' => 'Mobiltelefone']);
            $apple->electronicModels()->firstOrCreate(['name' => 'MacBook Air M3', 'category_hint' => 'Computer & Laptops']);
        }

        if ($samsung) {
            $samsung->electronicModels()->firstOrCreate(['name' => 'Galaxy S24 Ultra', 'category_hint' => 'Mobiltelefone']);
            $samsung->electronicModels()->firstOrCreate(['name' => 'Neo QLED QN90C', 'category_hint' => 'Fernseher']);
            $samsung->electronicModels()->firstOrCreate(['name' => 'RS68A Side-by-Side', 'category_hint' => 'Haushaltsgeräte']);
        }

        if ($sony) {
            $sony->electronicModels()->firstOrCreate(['name' => 'PlayStation 5', 'category_hint' => 'Gaming Konsolen']);
            $sony->electronicModels()->firstOrCreate(['name' => 'Bravia XR A95L', 'category_hint' => 'Fernseher']);
        }

        if ($lg) {
            $lg->electronicModels()->firstOrCreate(['name' => 'OLED evo G3', 'category_hint' => 'Fernseher']);
            $lg->electronicModels()->firstOrCreate(['name' => 'Waschmaschine F4WV709S1E', 'category_hint' => 'Haushaltsgeräte']);
        }

        if ($bosch) {
            $bosch->electronicModels()->firstOrCreate(['name' => 'Kühlschrank KGN36VL30', 'category_hint' => 'Haushaltsgeräte']);
            $bosch->electronicModels()->firstOrCreate(['name' => 'Geschirrspüler SMS68TI00E', 'category_hint' => 'Haushaltsgeräte']);
        }
    }
}