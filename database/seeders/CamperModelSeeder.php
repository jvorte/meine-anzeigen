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
            'Fiat' => ['Ducato', 'Talento'],
            'Ford' => ['Transit', 'Nugget', 'Tourneo Custom'],
            'Mercedes-Benz' => ['Sprinter', 'Marco Polo', 'Vito'],
            'Renault' => ['Master', 'Trafic'],
            'Volkswagen' => ['Transporter', 'Crafter', 'California', 'Caddy'],
            'Adria' => ['Adora', 'Coral', 'Sonic', 'Matrix', 'Compact', 'Twin Supreme'],
            'Bürstner' => ['Lyseo', 'Ixeo', 'Elegance', 'Viseo', 'Delfin'],
            'Dethleffs' => ['Globebus', 'Esprit', 'Advantage', 'Trend'],
            'Hymer' => ['Exsis', 'B-Class', 'ML-T', 'Grand Canyon S', 'Ayers Rock', 'Yosemite', 'Yellowstone'],
            'Knaus' => ['Sky Traveller', 'Van TI', 'Live I', 'L!ve Traveller', 'Boxstar', 'Boxdrive'],
            'Sunlight' => ['T-Series', 'I-Series', 'V-Series'],
            'Weinsberg' => ['CaraBus', 'CaraCompact', 'CaraLoft'],
            'Pilote' => ['Pacific', 'Foxy Van', 'Explorateur'],
            'Challenger' => ['Genesis', 'Magéo', 'Sirius'],
            'Chausson' => ['Flash', 'Welcome'],
            'Rapido' => ['Serie 6', 'Serie 8', 'Serie 9', 'Serie M'],
            'Westfalia' => ['Jules Verne', 'Amundsen', 'Columbus'],
            'Pössl' => ['Summit', 'Roadcruiser', '2Win'],
            'Auto-Sleepers' => ['Symbol', 'Warwick', 'Fairford', 'Kingham'],
            'La Strada' => ['Nova', 'Regent', 'Avanti'],
            'Dodge' => ['Promaster'],
            'Airstream' => ['Interstate', 'Atlas', 'Rangeline'],
            'Winnebago' => ['Solis', 'Travato', 'Revel', 'Ekko'],
            'Thor Motor Coach' => ['Sequence', 'Tellaro', 'Tranquility', 'Sanctuary'],
            'Coachmen' => ['Galleria', 'Beyond', 'Nova'],
            'Jayco' => ['Swift', 'Solstice', 'Terrain'],
            'Elnagh' => ['Baron', 'Magnum', 'T-Loft'],
            'Benimar' => ['Primero', 'Mileo', 'Tessoro'],
            'Panama' => ['P57'],
            'Malibu' => ['Van', 'GT', 'Genius'],
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
