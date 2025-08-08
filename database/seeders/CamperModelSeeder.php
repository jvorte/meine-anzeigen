<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CamperModel;
use App\Models\CamperBrand;
use Illuminate\Support\Str; // <-- Added this line

class CamperModelSeeder extends Seeder
{
    public function run(): void
    {
        $modelsData = [
            'Fiat' => ['Ducato'],
            'Ford' => ['Transit', 'Nugget'],
            'Mercedes-Benz' => ['Sprinter', 'Marco Polo'],
            'Renault' => ['Master', 'Trafic'],
            'Volkswagen' => ['Transporter', 'Crafter', 'California'],
            'Adria' => ['Adora', 'Coral', 'Sonic', 'Matrix', 'Compact'],
            'Bürstner' => ['Lyseo', 'Ixeo', 'Elegance', 'Viseo', 'Delfin'],
            'Dethleffs' => ['Globebus', 'Esprit', 'Advantage', 'Trend'],
            'Hymer' => ['Exsis', 'B-Class', 'ML-T', 'Grand Canyon S'],
            'Knaus' => ['Sky Traveller', 'Van TI', 'Live I', 'L!ve Traveller'],
            'Sunlight' => ['T-Series', 'I-Series', 'V-Series'],
            'Weinsberg' => ['CaraBus', 'CaraCompact', 'CaraLoft'],
            'Pilote' => ['Pacific', 'Foxy Van', 'Explorateur'],
            'Challenger' => ['Genesis', 'Magéo', 'Sirius'],
            'Chausson' => ['Flash', 'Welcome'],
            'Rapido' => ['Serie 6', 'Serie 8', 'Serie 9', 'Serie M'],
            'Westfalia' => ['Jules Verne', 'Amundsen', 'Columbus'],
            'Pössl' => ['Summit', 'Roadcruiser', '2Win'],
            'Other' => ['Other'],
        ];

        foreach ($modelsData as $brandName => $models) {
            $brand = CamperBrand::where('slug', Str::slug($brandName))->first(); // <-- Updated this line
            if ($brand) {
                foreach ($models as $modelName) {
                    CamperModel::firstOrCreate([
                        'camper_brand_id' => $brand->id,
                        'name' => $modelName,
                        'slug' => Str::slug($modelName), // <-- Updated this line
                    ]);
                }
            }
        }
    }
}