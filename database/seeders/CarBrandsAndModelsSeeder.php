<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class CarBrandsAndModelsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('car_models')->truncate();
        DB::table('car_brands')->truncate();

        $brandsData = [
            'Acura', 'Alfa Romeo', 'Alpine', 'Ariel', 'Aston Martin', 'Audi', 'Avatr', 'BAC', 'Bentley',
            'BMW', 'Buick', 'Bugatti', 'BYD', 'Cadillac', 'Canoo', 'Caterham', 'Changan', 'Chevrolet', 'Chery',
            'Chrysler', 'Citroën', 'Cupra', 'Dacia', 'Dodge', 'Donkervoort', 'Exeed', 'Faraday Future', 'Ferrari',
            'Fiat', 'Fisker', 'Ford', 'GAC', 'Genesis', 'Geely', 'GMC', 'Great Wall', 'Haval', 'HiPhi', 'Honda',
            'Hongqi', 'Hyundai', 'Infiniti', 'Jaguar', 'JAC', 'Jeep', 'Jetour', 'Kia', 'Koenigsegg',
            'Lamborghini', 'Land Rover', 'Leapmotor', 'Lexus', 'Li Auto', 'Lotus', 'Lucid', 'Lynk & Co',
            'Maserati', 'Mazda', 'McLaren', 'Mercedes-AMG', 'Mercedes-Benz', 'MG', 'Mini', 'Mitsubishi',
            'Morgan', 'Nio', 'Nissan', 'Noble', 'Opel', 'ORA', 'Pagani', 'Peugeot', 'Pininfarina',
            'Polestar', 'Porsche', 'Proton', 'Ram', 'Renault', 'Rimac', 'Rivian', 'Rolls-Royce', 'Roewe',
            'Seat', 'Seres', 'Skoda', 'SsangYong', 'Subaru', 'Suzuki', 'Tata', 'Tesla', 'Toyota', 'TVR',
            'Ultima', 'Volkswagen', 'Volvo', 'Voyah', 'Wiesmann', 'Wuling', 'Xpeng', 'Zeekr', 'Zhidou', 'Zhongxing',
            'Other', // Added the "Other" option
        ];

        $modelsData = [
            'Acura' => ['Integra', 'TLX', 'MDX', 'RDX', 'NSX', 'ADX'],
            'Alfa Romeo' => ['Giulia', 'Stelvio', 'Tonale', '4C'],
            'Alpine' => ['A110'],
            'Ariel' => ['Atom', 'Nomad'],
            'Aston Martin' => ['DB12', 'Vantage', 'DBX', 'Valhalla'],
            'Audi' => ['A3', 'A4', 'A5', 'A6', 'A7', 'A8', 'Q3', 'Q4 e-tron', 'Q5', 'Q7', 'Q8', 'e-tron', 'TT', 'R8'],
            'Bentley' => ['Continental GT', 'Flying Spur', 'Bentayga', 'Mulsanne'],
            'BMW' => ['2 Series', '3 Series', '4 Series', '5 Series', '7 Series', '8 Series', 'X1', 'X3', 'X5', 'X7', 'i4', 'i7', 'iX', 'Z4', 'M3', 'M5', 'iX3'],
            'Bugatti' => ['Chiron', 'Veyron', 'Divo', 'Bolide'],
            'BYD' => ['Atto 3', 'Dolphin', 'Seal', 'Han', 'Tang', 'Yuan Plus'],
            'Cadillac' => ['CT4', 'CT5', 'Escalade', 'XT4', 'XT5', 'XT6', 'Lyriq', 'Celestiq'],
            'Chevrolet' => ['Silverado', 'Equinox', 'Traverse', 'Malibu', 'Colorado', 'Tahoe', 'Suburban', 'Camaro', 'Corvette', 'Blazer', 'Trailblazer', 'Bolt EV', 'Spark'],
            'Chrysler' => ['300', 'Pacifica'],
            'Citroën' => ['C3', 'C4', 'C5 Aircross', 'Berlingo'],
            'Cupra' => ['Formentor', 'Ateca', 'Born', 'Raval'],
            'Dacia' => ['Sandero', 'Duster', 'Jogger', 'Spring'],
            'Dodge' => ['Charger', 'Challenger', 'Durango', 'Hornet'],
            'Ferrari' => ['Roma', 'SF90 Stradale', 'Purosangue', '296 GTB', '812 Superfast', 'LaFerrari'],
            'Fiat' => ['500', '500X', 'Panda', 'Tipo', 'Grande Panda'],
            'Ford' => ['F-150', 'Explorer', 'Escape', 'Mustang', 'Bronco', 'Ranger', 'Maverick', 'Edge', 'Expedition', 'Transit', 'Puma'],
            'Genesis' => ['G70', 'G80', 'G90', 'GV60', 'GV70', 'GV80'],
            'GMC' => ['Sierra 1500', 'Canyon', 'Acadia', 'Terrain', 'Yukon', 'Hummer EV'],
            'Honda' => ['Civic', 'Accord', 'CR-V', 'Pilot', 'Odyssey', 'Ridgeline', 'HR-V', 'Passport', 'Prelude'],
            'Hyundai' => ['Elantra', 'Sonata', 'Tucson', 'Santa Fe', 'Kona', 'Palisade', 'Ioniq 5', 'Ioniq 6', 'Nexo'],
            'Jaguar' => ['F-PACE', 'E-PACE', 'I-PACE', 'XF', 'XE', 'F-TYPE'],
            'Jeep' => ['Wrangler', 'Grand Cherokee', 'Cherokee', 'Compass', 'Renegade', 'Gladiator', 'Wagoneer', 'Recon'],
            'Kia' => ['Forte', 'K5', 'Sportage', 'Sorento', 'Telluride', 'Soul', 'Seltos', 'Niro', 'EV6', 'EV9'],
            'Koenigsegg' => ['Jesko', 'Gemera', 'Regera'],
            'Lamborghini' => ['Huracán', 'Urus', 'Revuelto', 'Aventador', 'Gallardo'],
            'Land Rover' => ['Range Rover', 'Defender', 'Discovery', 'Range Rover Sport', 'Range Rover Evoque', 'Range Rover Velar'],
            'Lexus' => ['ES', 'RX', 'NX', 'IS', 'LS', 'GX', 'LX', 'RC', 'LC', 'UX', 'RZ'],
            'Lotus' => ['Emira', 'Evija', 'Eletre', 'Elise'],
            'Lucid' => ['Air'],
            'Maserati' => ['Ghibli', 'Levante', 'Quattroporte', 'MC20', 'Grecale'],
            'Mazda' => ['Mazda3', 'Mazda6', 'CX-30', 'CX-5', 'CX-50', 'CX-90', 'MX-5 Miata'],
            'McLaren' => ['720S', 'Artura', 'GT', 'Speedtail', 'Senna'],
            'Mercedes-Benz' => ['C-Class', 'E-Class', 'S-Class', 'GLC', 'GLE', 'GLS', 'A-Class', 'G-Class', 'EQS', 'EQE', 'GLA'],
            'MG' => ['ZS', 'HS', 'MG4 EV', 'Cyberster'],
            'Mini' => ['Cooper', 'Countryman', 'Clubman'],
            'Mitsubishi' => ['Outlander', 'Outlander Sport', 'Eclipse Cross', 'Mirage'],
            'Nissan' => ['Altima', 'Sentra', 'Rogue', 'Titan', 'Frontier', 'Murano', 'Pathfinder', 'Versa', 'Kicks', 'Leaf', 'GT-R', 'Z'],
            'Polestar' => ['Polestar 2', 'Polestar 3', 'Polestar 4'],
            'Porsche' => ['911', 'Cayenne', 'Macan', 'Panamera', 'Taycan', '718 Boxster', '718 Cayman'],
            'Ram' => ['1500', '2500', '3500'],
            'Renault' => ['Clio', 'Captur', 'Megane', 'Arkana'],
            'Rimac' => ['Nevera'],
            'Rivian' => ['R1T', 'R1S'],
            'Rolls-Royce' => ['Phantom', 'Ghost', 'Cullinan', 'Wraith', 'Spectre'],
            'Seat' => ['Ibiza', 'Leon', 'Arona', 'Ateca', 'Tarraco'],
            'Skoda' => ['Octavia', 'Superb', 'Karoq', 'Kodiaq', 'Fabia'],
            'Subaru' => ['Impreza', 'Legacy', 'Forester', 'Outback', 'Crosstrek', 'Ascent', 'WRX', 'BRZ', 'Solterra'],
            'Suzuki' => ['Swift', 'Vitara', 'Jimny'],
            'Tesla' => ['Model 3', 'Model S', 'Model X', 'Model Y', 'Cybertruck'],
            'Toyota' => ['Camry', 'Corolla', 'RAV4', 'Highlander', 'Tacoma', 'Tundra', 'Prius', 'Sienna', '4Runner', 'Supra', 'GR86', 'Yaris'],
            'Volkswagen' => ['Golf', 'Jetta', 'Passat', 'Tiguan', 'Atlas', 'ID.4', 'Polo', 'Arteon'],
            'Volvo' => ['S60', 'S90', 'XC40', 'XC60', 'XC90', 'C40 Recharge', 'EX30', 'EX90'],
            'Xpeng' => ['P7', 'G3', 'P5', 'G9'],
            'Other' => ['Other'], // Updated to include 'Other' with a corresponding 'Other' model.
        ];

        $now = Carbon::now();

        foreach ($brandsData as $brandName) {
            $brandId = DB::table('car_brands')->insertGetId([
                'name' => $brandName,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            if (isset($modelsData[$brandName])) {
                $modelsToInsert = [];
                foreach ($modelsData[$brandName] as $modelName) {
                    $modelsToInsert[] = [
                        'car_brand_id' => $brandId,
                        'name' => $modelName,
                        'slug' => Str::slug($modelName),
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];
                }
                foreach (array_chunk($modelsToInsert, 1000) as $chunk) {
                    DB::table('car_models')->insertOrIgnore($chunk);
                }
            }
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->command->info('Car brands and models seeded successfully! 🚗');
    }
}