<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Brand;
use App\Models\CarModel;
use Illuminate\Support\Str;

class ImportVehicleData extends Command
{
    protected $signature = 'import:vehicles';
    protected $description = 'Import all vehicle brands and models from NHTSA API';

    public function handle()
    {
        $this->info('Fetching all car brands...');

        $response = Http::get('https://vpic.nhtsa.dot.gov/api/vehicles/GetMakesForVehicleType/car?format=json');

        if (!$response->successful()) {
            $this->error('Failed to get brands from API');
            return 1;
        }

        $brandsData = $response->json()['Results'] ?? [];

        foreach ($brandsData as $brandItem) {
            $brandName = trim($brandItem['MakeName']);

            $brand = Brand::firstOrCreate(
                ['name' => $brandName],
                ['slug' => Str::slug($brandName)]
            );

            $this->info("Imported brand: {$brandName}");

            // Φέρε τα μοντέλα για το συγκεκριμένο brand
            $modelResponse = Http::get("https://vpic.nhtsa.dot.gov/api/vehicles/GetModelsForMake/{$brandName}?format=json");

            if (!$modelResponse->successful()) {
                $this->warn("Failed to get models for brand: {$brandName}");
                continue;
            }

            $modelData = $modelResponse->json();

            if (!isset($modelData['Results']) || !is_array($modelData['Results'])) {
                $this->warn("No models found for brand: {$brandName}");
                continue;
            }

            $models = $modelData['Results'];

            foreach ($models as $modelItem) {
                $modelName = trim($modelItem['Model_Name']);
                $baseSlug = Str::slug($modelName . '-' . $brand->id);

                $slug = $baseSlug;
                $counter = 1;

                // Έλεγχος αν το slug υπάρχει ήδη, και αν ναι, πρόσθεσε αριθμό για μοναδικότητα
                while (CarModel::where('slug', $slug)->exists()) {
                    $slug = $baseSlug . '-' . $counter;
                    $counter++;
                }

                CarModel::updateOrCreate(
                    [
                        'name' => $modelName,
                        'brand_id' => $brand->id,
                    ],
                    [
                        'slug' => $slug,
                    ]
                );
            }

            $this->info("Imported " . count($models) . " models for brand {$brandName}");
        }

        $this->info('Import finished.');

        return 0;
    }
}
