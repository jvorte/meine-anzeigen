<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MotorcycleBrand;
use App\Models\MotorcycleModel;
use Illuminate\Support\Facades\DB; // Import DB facade

class MotorcycleBrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Temporarily disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Clear existing data by truncating tables
        // Truncate models first, as brands are referenced by models
        // And motorrad_ads references models, so truncating models first is safer
        MotorcycleModel::truncate();
        MotorcycleBrand::truncate();

        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');


        $brandsWithModels = [
            'Honda' => ['CBR1000RR', 'Rebel 500', 'Africa Twin', 'Gold Wing', 'CRF450R'],
            'Yamaha' => ['YZF-R1', 'MT-07', 'Tenere 700', 'XSR900', 'NMAX 155'],
            'Kawasaki' => ['Ninja ZX-10R', 'Z900', 'Versys 650', 'Vulcan S', 'KX450'],
            'Suzuki' => ['GSX-R1000', 'V-Strom 650', 'SV650', 'Hayabusa', 'DR-Z400SM'],
            'Harley-Davidson' => ['Street Glide', 'Iron 883', 'Fat Boy', 'Sportster S', 'Pan America 1250'],
            'BMW' => ['S 1000 RR', 'R 1250 GS', 'F 900 R', 'G 310 GS', 'K 1600 GT'],
            'Ducati' => ['Panigale V4', 'Monster', 'Multistrada V4', 'Scrambler Icon', 'Diavel 1260'],
            'KTM' => ['1290 Super Duke R', '390 Duke', '890 Adventure', 'RC 390', 'EXC 300'],
            'Triumph' => ['Street Triple', 'Bonneville T120', 'Tiger 900', 'Speed Twin', 'Rocket 3'],
            'Aprilia' => ['RSV4', 'Tuono 660', 'Tuareg 660', 'SR GT 200'],
            'Moto Guzzi' => ['V7 Stone', 'V85 TT', 'California 1400'],
            'Vespa' => ['Primavera 125', 'GTS 300', 'Sprint 150'],
            'Royal Enfield' => ['Interceptor 650', 'Classic 350', 'Himalayan'],
            'Indian' => ['Chief', 'Scout', 'Challenger'],
            'Husqvarna' => ['Norden 901', 'Svartpilen 401', 'Vitpilen 701'],
            'Zero Motorcycles' => ['SR/S', 'FXE', 'DSR/X'],
            'Energica' => ['Ego+', 'EsseEsse9+', 'Experia'],
            'LiveWire' => ['S2 Del Mar', 'One'],
            'CFMoto' => ['450SR', '800NK', '700CL-X'],
            'Benelli' => ['Leoncino 500', 'TRK 502', 'Imperiale 400'],
            'MV Agusta' => ['Brutale 800', 'F3 800', 'Superveloce 800'],
            // Add other brands you want to include without specific models here, they will just be brands
            'Norton' => [], 'Brough Superior' => [], 'Can-Am' => [], 'Polaris' => [], 'TVS' => [],
            'Bajaj' => [], 'Hero MotoCorp' => [], 'Mahindra' => [], 'Hyosung' => [], 'Kymco' => [],
            'SYM' => [], 'Loncin' => [], 'Zongshen' => [], 'Qianjiang' => [], 'Garelli' => [],
            'Malaguti' => [], 'Fantic' => [], 'Scorpa' => [], 'Vertigo' => [], 'Montesa' => [],
            'Cagiva' => [], 'Derbi' => [], 'Gilera' => [], 'Laverda' => [], 'Bimota' => [],
            'Victory Motorcycles' => [], 'EBR Motorcycles' => [], 'Buell Motorcycle Company' => [],
            'Alta Motors (defunct)' => [], 'Lightning Motorcycles Corp.' => [], 'Curtiss Motorcycles (formerly Confederate)' => [],
            'Arc Vehicle Ltd' => [], 'Damon Motors Inc.' => [], 'Sondors Inc.' => [],
            'Cake 0 Emission AB' => [], 'Super Soco (VMoto Soco Group)' => [],
            'Niu Technologies' => [], 'Silence Urban Ecomobility' => [], 'Horwin (Horwin Europe GmbH)' => [],
            'Voge (Loncin Motor Co., Ltd.)' => [], 'Brixton Motorcycles (KSR Group GmbH)' => [],
            'Zontes (Guangdong Tayo Motorcycle Technology Co., Ltd.)' => [],
            'Macbor (Motana S.A.)' => [], 'SWM Motorcycles' => [], 'TM Racing S.p.A.' => [],
            'AJP Motos' => [], 'Rieju S.A.' => [], 'Oset Bikes' => [], 'Sur-Ron (Zhejiang Sur-Ron Technology Co., Ltd.)' => [],
            'Stark Future S.L.' => [], 'Volcon Inc.' => [], 'Kayo USA' => [], 'Pitster Pro' => [],
            'SSR Motorsports' => [], 'Apollo Motors' => [], 'TaoTao USA' => [],
            'Coleman Powersports' => [], 'Hisun Motors Corp., USA' => [],
            'Massimo Motor Sports, LLC' => [], 'Segway Powersports (Segway-Ninebot)' => [],
            'CFMOTO Powersports (CFMOTO)' => [],
        ];

        foreach ($brandsWithModels as $brandName => $models) {
            $motorcycleBrand = MotorcycleBrand::firstOrCreate(['name' => $brandName]);
            foreach ($models as $modelName) {
                MotorcycleModel::firstOrCreate([
                    'motorcycle_brand_id' => $motorcycleBrand->id,
                    'name' => $modelName
                ]);
            }
        }
    }
}
