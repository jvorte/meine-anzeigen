<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Brand;
use App\Models\Model;
use Illuminate\Support\Str;


class ImportCarData extends Command
{
    protected $signature = 'car:import';

    protected $description = 'Import car brands and models from external API';

    public function handle()
    {
        // Παράδειγμα API endpoint (θα το αλλάξεις ανάλογα)
        $response = Http::get('https://api.example.com/cars/brands-models');

        if ($response->successful()) {
            $data = $response->json();

            foreach ($data as $brandName => $models) {
                $brand = Brand::updateOrCreate(
                    ['slug' => Str::slug($brandName)],
                    ['name' => $brandName]
                );

                foreach ($models as $modelName) {
                    Model::updateOrCreate(
                        ['brand_id' => $brand->id, 'slug' => Str::slug($modelName)],
                        ['name' => $modelName]
                    );
                }
            }

            $this->info('Brands and models imported successfully.');
        } else {
            $this->error('API request failed.');
        }
    }
}