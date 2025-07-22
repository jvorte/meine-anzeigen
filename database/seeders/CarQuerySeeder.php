<?php
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use App\Models\Brand;
use App\Models\CarModel;

class CarQuerySeeder extends Seeder
{
    public function run()
    {
        $types = ['car', 'motorcycle'];
        
        foreach ($types as $type) {
            $this->command->info("Importing brands for type: $type");

            $response = Http::get("https://www.carqueryapi.com/api/0.3/?cmd=getMakes&sold_in_us=1&vehicle_type=$type");
            $data = json_decode($response->body(), true);
            $brands = $data['Makes'] ?? [];

            foreach ($brands as $brandItem) {
                $brandName = $brandItem['make_display'];
                $brand = Brand::updateOrCreate(
                    ['name' => $brandName, 'type' => $type],
                    ['slug' => Str::slug($brandName), 'type' => $type]
                );

                $this->command->info("Imported brand $brandName");

                // Πάρε τα μοντέλα για το brand
                $modelResponse = Http::get("https://www.carqueryapi.com/api/0.3/?cmd=getModels&make={$brandItem['make_name']}&sold_in_us=1&vehicle_type=$type");
                $modelData = json_decode($modelResponse->body(), true);
                $models = $modelData['Models'] ?? [];

                foreach ($models as $modelItem) {
                    $modelName = $modelItem['model_name'];
                    CarModel::updateOrCreate(
                        ['brand_id' => $brand->id, 'name' => $modelName],
                        ['slug' => Str::slug($modelName), 'type' => $type]
                    );
                }

                $this->command->info("Imported " . count($models) . " models for $brandName");
            }
        }
    }
}
