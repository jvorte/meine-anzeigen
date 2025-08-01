<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CommercialBrand; // Don't forget to import your brand model
use App\Models\CommercialModel; // Don't forget to import your model model

class CommercialModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brandModels = [
            'Volkswagen' => [
                'Caddy', 'Transporter', 'Crafter', 'Multivan', 'California'
            ],
            'Mercedes-Benz' => [
                'Citan', 'Vito', 'Sprinter', 'V-Class'
            ],
            'Ford' => [
                'Transit Connect', 'Transit Custom', 'Transit', 'Tourneo Connect', 'Tourneo Custom'
            ],
            'Renault' => [
                'Kangoo', 'Trafic', 'Master'
            ],
            'Peugeot' => [
                'Partner', 'Expert', 'Boxer', 'Traveller'
            ],
            'Citroën' => [
                'Berlingo', 'Jumpy', 'Jumper', 'SpaceTourer'
            ],
            'Opel' => [
                'Combo', 'Vivaro', 'Movano', 'Zafira Life'
            ],
            'Toyota' => [
                'Proace City', 'Proace', 'Proace Verso'
            ],
            'Fiat' => [
                'Doblo Cargo', 'Talento', 'Ducato'
            ],
            'Hyundai' => [
                'H-1', 'Staria'
            ],
            'Nissan' => [
                'NV200', 'NV300', 'NV400'
            ],
            'Iveco' => [
                'Daily Van', 'Daily Minibus'
            ],
            // Add more brands and their models as needed
        ];

        foreach ($brandModels as $brandName => $models) {
            $brand = CommercialBrand::where('name', $brandName)->first();

            if ($brand) { // Ensure the brand exists before adding models
                foreach ($models as $modelName) {
                    CommercialModel::firstOrCreate(
                        ['commercial_brand_id' => $brand->id, 'name' => $modelName]
                    );
                }
            } else {
                $this->command->warn("Brand '{$brandName}' not found, skipping its models.");
            }
        }
    }
}