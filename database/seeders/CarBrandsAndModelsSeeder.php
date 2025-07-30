<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str; // Import Str facade for slug generation
use Carbon\Carbon;

class CarBrandsAndModelsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable foreign key checks for seeding
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Clear existing data to prevent duplicates on re-run
        // IMPORTANT: Ensure these table names match your actual tables
        DB::table('car_models')->truncate();
        DB::table('car_brands')->truncate(); // Renamed from 'brands' to 'car_brands'

        $brandsData = [
            'Toyota', 'Honda', 'Ford', 'Chevrolet', 'BMW', 'Mercedes-Benz', 'Audi', 'Volkswagen',
            'Nissan', 'Hyundai', 'Kia', 'Subaru', 'Mazda', 'Volvo', 'Tesla', 'Porsche',
            'Ferrari', 'Lamborghini', 'Fiat', 'Jeep', 'Land Rover', 'Lexus', 'Acura', 'Infiniti',
            'Chrysler', 'Dodge', 'Ram', 'GMC', 'Cadillac', 'Buick', 'Mitsubishi', 'Suzuki',
            'Alfa Romeo', 'Maserati', 'Jaguar', 'Mini', 'Smart', 'Bentley', 'Rolls-Royce', 'McLaren',
            'Bugatti', 'Koenigsegg', 'Pagani', 'Rivian', 'Lucid', 'Polestar', 'Genesis', 'BYD', 'Geely',
            'Chery', 'Great Wall', 'MG', 'Peugeot', 'Renault', 'Citroën', 'Opel', 'Skoda', 'Seat',
            'Dacia', 'SsangYong', 'Proton', 'Perodua', 'Tata', 'Mahindra', 'Foton',
            'Haval', 'Changan', 'Wuling', 'Zotye', 'Dongfeng', 'FAW', 'GAC', 'Hongqi', 'Lynk & Co',
            'Nio', 'Xpeng', 'Zeekr', 'Leapmotor', 'Voyah', 'Arcfox', 'Denza', 'HiPhi', 'Avatr',
            'WEY', 'ORA', 'Tank', 'Jetour', 'Exeed', 'GWM Pickup', 'Maxus', 'IM Motors', 'AITO',
            'Li Auto', 'Seres', 'Zhidou', 'Aiways', 'Karma', 'Faraday Future', 'Nikola',
            'Canoo', 'Aptera', 'Lightyear', 'Sono Motors', 'Fisker', 'Lordstown Motors', 'Bollinger',
            'Rimac', 'Pininfarina', 'Hispano Suiza', 'De Tomaso', 'TVR', 'Morgan', 'Caterham', 'Lotus',
            'Alpine', 'Dallara', 'Ariel', 'BAC', 'Ultima', 'Noble', 'Radical', 'Donkervoort', 'Spyker',
            'Wiesmann', 'Gumpert', 'Artega', 'Veritas', 'Melkus', 'Loremo', 'ED Design', 'Icona',
            'Qoros', 'Borgward', 'Baojun', 'Venucia', 'Bestune', 'Maple', 'Roewe', 'JAC',
            'Zhongtong', 'Yutong', 'King Long', 'Golden Dragon', 'Higer', 'BYD Bus', 'Foton Bus',
            'Ankai', 'Youngman', 'Nanjing Auto', 'Brilliance', 'Haima', 'Lifan', 'Zhongxing', 'Gonow',
            'Hawtai', 'Shuanghuan', 'Changfeng', 'Changhe'
        ];

        $modelsData = [
            'Toyota' => ['Camry', 'Corolla', 'RAV4', 'Highlander', 'Tacoma', 'Tundra', 'Prius', 'Sienna', '4Runner', 'Supra', 'GR86', 'Yaris', 'C-HR', 'Venza', 'Mirai', 'Sequoia', 'Crown', 'Corolla Cross'],
            'Honda' => ['Civic', 'Accord', 'CR-V', 'Pilot', 'Odyssey', 'Ridgeline', 'HR-V', 'Passport', 'Insight', 'Clarity', 'Fit', 'Prelude', 'NSX', 'CR-Z', 'S2000'],
            'Ford' => ['F-150', 'Explorer', 'Escape', 'Mustang', 'Bronco', 'Ranger', 'Maverick', 'Edge', 'Expedition', 'Transit', 'EcoSport', 'Focus', 'Fiesta', 'Fusion', 'GT'],
            'Chevrolet' => ['Silverado', 'Equinox', 'Traverse', 'Malibu', 'Colorado', 'Tahoe', 'Suburban', 'Camaro', 'Corvette', 'Blazer', 'Trailblazer', 'Bolt EV', 'Spark', 'Trax', 'Express'],
            'BMW' => ['3 Series', '5 Series', '7 Series', 'X1', 'X3', 'X5', 'X7', 'Z4', 'M3', 'M5', 'i4', 'iX', '2 Series', '4 Series', '8 Series', 'Z3', 'i3', 'i8'],
            'Mercedes-Benz' => ['C-Class', 'E-Class', 'S-Class', 'GLC', 'GLE', 'GLS', 'A-Class', 'CLA', 'CLS', 'G-Class', 'EQS', 'EQE', 'GLA', 'EQB', 'AMG GT', 'SL', 'SLC', 'SLK', 'B-Class'],
            'Audi' => ['A3', 'A4', 'A6', 'A8', 'Q3', 'Q5', 'Q7', 'Q8', 'e-tron', 'S4', 'RS5', 'TT', 'R8', 'A5', 'A7', 'Q4 e-tron', 'SQ5', 'RSQ8'],
            'Volkswagen' => ['Golf', 'Jetta', 'Passat', 'Tiguan', 'Atlas', 'ID.4', 'Polo', 'Arteon', 'Taos', 'Touareg', 'Beetle', 'GTI', 'R32', 'Eos', 'Scirocco'],
            'Nissan' => ['Altima', 'Sentra', 'Rogue', 'Titan', 'Frontier', 'Murano', 'Pathfinder', 'Versa', 'Kicks', 'Leaf', 'GT-R', 'Z', 'Armada', 'Maxima', 'Quest'],
            'Hyundai' => ['Elantra', 'Sonata', 'Tucson', 'Santa Fe', 'Kona', 'Palisade', 'Venue', 'Nexo', 'Ioniq 5', 'Accent', 'Veloster', 'Genesis Coupe'],
            'Kia' => ['Forte', 'K5', 'Sportage', 'Sorento', 'Telluride', 'Soul', 'Seltos', 'Niro', 'EV6', 'Rio', 'Stinger', 'Carnival', 'Cadenza', 'K900'],
            'Subaru' => ['Impreza', 'Legacy', 'Forester', 'Outback', 'Crosstrek', 'Ascent', 'WRX', 'BRZ', 'Solterra'],
            'Mazda' => ['Mazda3', 'Mazda6', 'CX-30', 'CX-5', 'CX-9', 'MX-5 Miata', 'CX-50', 'CX-90'],
            'Volvo' => ['S60', 'S90', 'V60', 'V90', 'XC40', 'XC60', 'XC90', 'C40 Recharge', 'EX30', 'EX90'],
            'Tesla' => ['Model 3', 'Model S', 'Model X', 'Model Y', 'Cybertruck', 'Roadster'],
            'Porsche' => ['911', 'Cayenne', 'Macan', 'Panamera', 'Taycan', '718 Boxster', '718 Cayman', 'Carrera GT', '918 Spyder'],
            'Ferrari' => ['296 GTB', 'SF90 Stradale', 'Roma', 'Portofino', '812 Superfast', 'F8 Tributo', 'Daytona SP3', 'Purosangue', 'LaFerrari', 'Enzo'],
            'Lamborghini' => ['Huracán', 'Urus', 'Revuelto', 'Aventador', 'Gallardo', 'Murciélago', 'Diablo', 'Countach'],
            'Fiat' => ['500', '500X', '500L', '124 Spider', 'Panda', 'Tipo', 'Ducato'],
            'Jeep' => ['Wrangler', 'Grand Cherokee', 'Cherokee', 'Compass', 'Renegade', 'Gladiator', 'Wagoneer', 'Grand Wagoneer'],
            'Land Rover' => ['Range Rover', 'Range Rover Sport', 'Discovery', 'Defender', 'Discovery Sport', 'Range Rover Evoque', 'Range Rover Velar'],
            'Lexus' => ['ES', 'RX', 'NX', 'IS', 'LS', 'GX', 'LX', 'RC', 'LC', 'UX', 'RZ'],
            'Acura' => ['Integra', 'TLX', 'MDX', 'RDX', 'NSX', 'ILX'],
            'Infiniti' => ['Q50', 'QX50', 'QX60', 'Q60', 'QX80', 'Q70'],
            'Chrysler' => ['300', 'Pacifica', 'Voyager'],
            'Dodge' => ['Charger', 'Challenger', 'Durango', 'Hornet', 'Journey', 'Grand Caravan'],
            'Ram' => ['1500', '2500', '3500', 'ProMaster', 'ProMaster City'],
            'GMC' => ['Sierra 1500', 'Sierra HD', 'Canyon', 'Acadia', 'Terrain', 'Yukon', 'Yukon XL', 'Hummer EV'],
            'Cadillac' => ['CT4', 'CT5', 'Escalade', 'XT4', 'XT5', 'XT6', 'Lyriq', 'Celestiq'],
            'Buick' => ['Encore GX', 'Envision', 'Enclave', 'Envista', 'Regal', 'LaCrosse'],
            'Mitsubishi' => ['Outlander', 'Outlander Sport', 'Eclipse Cross', 'Mirage', 'Triton/L200', 'Pajero'],
            'Suzuki' => ['Swift', 'Vitara', 'Jimny', 'Ignis', 'Celerio', 'Baleno'],
            'Alfa Romeo' => ['Giulia', 'Stelvio', 'Tonale', '4C'],
            'Maserati' => ['Ghibli', 'Levante', 'Quattroporte', 'MC20', 'GranTurismo', 'Grecale'],
            'Jaguar' => ['F-PACE', 'E-PACE', 'I-PACE', 'XF', 'XE', 'F-TYPE', 'XJ'],
            'Mini' => ['Cooper', 'Countryman', 'Clubman', 'Convertible'],
            'Smart' => ['Fortwo', 'Forfour'],
            'Bentley' => ['Continental GT', 'Flying Spur', 'Bentayga', 'Mulsanne'],
            'Rolls-Royce' => ['Phantom', 'Ghost', 'Cullinan', 'Wraith', 'Dawn', 'Spectre'],
            'McLaren' => ['720S', '750S', 'Artura', 'GT', 'Speedtail', 'Senna', 'P1', 'Elva'],
            'Bugatti' => ['Chiron', 'Veyron', 'Divo', 'Centodieci', 'Bolide'],
            'Koenigsegg' => ['Jesko', 'Gemera', 'Regera', 'Agera', 'CCX'],
            'Pagani' => ['Huayra', 'Zonda', 'Utopia'],
            'Rivian' => ['R1T', 'R1S'],
            'Lucid' => ['Air'],
            'Polestar' => ['Polestar 2', 'Polestar 3', 'Polestar 4'],
            'Genesis' => ['G70', 'G80', 'G90', 'GV60', 'GV70', 'GV80'],
            'BYD' => ['Atto 3', 'Dolphin', 'Seal', 'Han', 'Tang'],
            'Geely' => ['Coolray', 'Tugella', 'Azkarra', 'Emgrand', 'Monjaro'],
            'Chery' => ['Tiggo 7 Pro', 'Tiggo 8 Pro', 'Omoda 5', 'Arrizo 5'],
            'Great Wall' => ['Cannon', 'Poer', 'Haval H6', 'Tank 300'],
            'MG' => ['ZS', 'HS', 'MG4 EV', 'Cyberster', 'MG5', 'MG ZS EV'],
            'Peugeot' => ['208', '308', '2008', '3008', '5008', '508', 'e-208', 'e-2008'],
            'Renault' => ['Clio', 'Captur', 'Megane', 'Arkana', 'Austral', 'Zoe', 'Twingo', 'Duster (Dacia)'],
            'Citroën' => ['C3', 'C4', 'C5 Aircross', 'ë-C4', 'Berlingo', 'C3 Aircross'],
            'Opel' => ['Corsa', 'Astra', 'Mokka', 'Grandland', 'Crossland', 'Vauxhall (UK)'],
            'Skoda' => ['Octavia', 'Superb', 'Karoq', 'Kodiaq', 'Fabia', 'Enyaq'],
            'Seat' => ['Ibiza', 'Leon', 'Arona', 'Ateca', 'Tarraco', 'Formentor (Cupra)'],
            'Dacia' => ['Sandero', 'Duster', 'Jogger', 'Spring'],
            'SsangYong' => ['Korando', 'Rexton', 'Tivoli', 'Musso'],
            'Proton' => ['Saga', 'Persona', 'X50', 'X70'],
            'Perodua' => ['Myvi', 'Alza', 'Ativa', 'Bezza'],
            'Tata' => ['Nexon', 'Punch', 'Harrier', 'Safari', 'Tiago', 'Altroz'],
            'Mahindra' => ['Thar', 'XUV700', 'Scorpio-N', 'Bolero'],
            'Foton' => ['Tunland', 'Gratour', 'Sauvana'],
            'Haval' => ['H6', 'Jolion', 'H9', 'F7'],
            'Changan' => ['CS75 Plus', 'CS55 Plus', 'UNI-T', 'UNI-K', 'Alsvin'],
            'Wuling' => ['Hongguang Mini EV', 'Almaz', 'Cortez'],
            'Zotye' => ['T600', 'Z500', 'SR9'],
            'Dongfeng' => ['Fengon 580', 'Aeolus Yixuan', 'Forthing T5 EVO'],
            'FAW' => ['Bestune B70', 'Bestune T77', 'Hongqi H5', 'Hongqi H9'],
            'GAC' => ['GS4', 'GS8', 'GA6', 'Aion S', 'Aion V'],
            'Hongqi' => ['H5', 'H9', 'E-HS9', 'HS5', 'HS7'],
            'Lynk & Co' => ['01', '02', '03', '05', '06', '09'],
            'Nio' => ['ES6', 'ES8', 'ET5', 'ET7', 'EC6', 'EC7'],
            'Xpeng' => ['P7', 'G3', 'P5', 'G9'],
            'Zeekr' => ['001', '009', 'X'],
            'Leapmotor' => ['C11', 'T03', 'C01'],
            'Voyah' => ['Free', 'Dreamer'],
            'Arcfox' => ['Alpha S', 'Alpha T'],
            'Denza' => ['D9', 'N7'],
            'HiPhi' => ['X', 'Z', 'Y'],
            'Avatr' => ['11'],
            'WEY' => ['Mocha', 'Latte', 'Macchiato', 'Coffee 01'],
            'ORA' => ['Good Cat', 'Funky Cat', 'Lightning Cat'],
            'Tank' => ['300', '500'],
            'Jetour' => ['X70', 'X90', 'Dashing'],
            'Exeed' => ['TXL', 'LX', 'VX'],
            'GWM Pickup' => ['Poer', 'King Kong Poer'],
            'Maxus' => ['D90', 'T60', 'T90', 'V80', 'G10', 'MIFA 9'],
            'IM Motors' => ['L7', 'LS7'],
            'AITO' => ['M5', 'M7'],
            'Li Auto' => ['L7', 'L8', 'L9', 'ONE'],
            'Seres' => ['SF5', 'SF7'],
            'Zhidou' => ['D2', 'D3'],
            'Aiways' => ['U5', 'U6'],
            'Karma' => ['Revero GT'],
            'Faraday Future' => ['FF 91'],
            'Nikola' => ['Badger (discontinued)', 'Tre'],
            'Canoo' => ['Lifestyle Vehicle', 'Pickup Truck'],
            'Aptera' => ['Aptera'],
            'Lightyear' => ['Lightyear 0'],
            'Sono Motors' => ['Sion (discontinued)'],
            'Fisker' => ['Ocean', 'Pear'],
            'Lordstown Motors' => ['Endurance'],
            'Bollinger' => ['B1', 'B2'],
            'Rimac' => ['Nevera'],
            'Pininfarina' => ['Battista'],
            'Hispano Suiza' => ['Carmen'],
            'De Tomaso' => ['P72'],
            'TVR' => ['Griffith'],
            'Morgan' => ['Plus Four', 'Plus Six', 'Super 3'],
            'Caterham' => ['Seven 170', 'Seven 340', 'Seven 480'],
            'Lotus' => ['Emira', 'Evija', 'Eletre', 'Elise', 'Exige', 'Evora'],
            'Alpine' => ['A110'],
            'Dallara' => ['Stradale'],
            'Ariel' => ['Atom', 'Nomad'],
            'BAC' => ['Mono'],
            'Ultima' => ['Evolution', 'RS'],
            'Noble' => ['M600'],
            'Radical' => ['SR1', 'SR3', 'SR10'],
            'Donkervoort' => ['D8 GTO'],
            'Spyker' => ['C8'],
            'Wiesmann' => ['Project Thunderball'],
            'Gumpert' => ['Apollo'],
            'Artega' => ['GT'],
            'Veritas' => ['RS III'],
            'Melkus' => ['RS 1000'],
            'Loremo' => ['LS', 'GT'],
            'ED Design' => ['Toro'],
            'Icona' => ['Vulcano'],
            'Qoros' => ['3 Sedan', '3 SUV', '5 SUV'],
            'Borgward' => ['BX5', 'BX7'],
            'Baojun' => ['510', '530', 'RS-3', 'Kiwi EV'],
            'Venucia' => ['D60', 'T60', 'V-Online'],
            'Bestune' => ['B70', 'T77', 'T99'],
            'Maple' => ['30X', '60S'],
            'Roewe' => ['RX5', 'i5', 'i6 MAX', 'Marvel R'],
            'JAC' => ['JS4', 'JS3', 'T8 Pro', 'e-JS1'],
            'Zhongtong' => ['Bus models'], // Generic for bus manufacturers
            'Yutong' => ['Bus models'],
            'King Long' => ['Bus models'],
            'Golden Dragon' => ['Bus models'],
            'Higer' => ['Bus models'],
            'BYD Bus' => ['Bus models'],
            'Foton Bus' => ['Bus models'],
            'Ankai' => ['Bus models'],
            'Youngman' => ['Bus models'],
            'Nanjing Auto' => ['NJ2046', 'NJ2045'],
            'Brilliance' => ['V3', 'V7', 'H530'],
            'Haima' => ['S5', '8S', '7X'],
            'Lifan' => ['X60', '820', '530'],
            'Zhongxing' => ['Grand Tiger', 'Terralord'],
            'Gonow' => ['GA200', 'GS200'],
            'Hawtai' => ['B35', 'E70'],
            'Shuanghuan' => ['SCEO', 'CEO'],
            'Changfeng' => ['Liebao Q6', 'Leopard CS10'],
            'Changhe' => ['Q7', 'A6', 'M70']
        ];


        $now = Carbon::now();

        foreach ($brandsData as $brandName) {
            $brandId = DB::table('car_brands')->insertGetId([ // Updated to 'car_brands'
                'name' => $brandName,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            if (isset($modelsData[$brandName])) {
                $modelsToInsert = [];
                foreach ($modelsData[$brandName] as $modelName) {
                    $modelsToInsert[] = [
                        'car_brand_id' => $brandId, // Updated to 'car_brand_id'
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

        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->command->info('Car brands and models seeded successfully!');
    }
}
