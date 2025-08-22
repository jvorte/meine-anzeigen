<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MotorcycleBrand;
use App\Models\MotorcycleModel;
use Illuminate\Support\Facades\DB;

class MotorcycleBrandSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        MotorcycleModel::truncate();
        MotorcycleBrand::truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

  $brandsWithModels = [
    // Major Japanese Brands
    'Honda' => ['CBR1000RR', 'Rebel 500', 'Africa Twin', 'Gold Wing', 'CRF450R', 'CB500F', 'NC750X'],
    'Yamaha' => ['YZF-R1', 'MT-07', 'Tenere 700', 'XSR900', 'NMAX 155', 'Tracer 9 GT', 'R7'],
    'Kawasaki' => ['Ninja ZX-10R', 'Z900', 'Versys 650', 'Vulcan S', 'KX450', 'Ninja 400', 'Z650RS'],
    'Suzuki' => ['GSX-R1000', 'V-Strom 650', 'SV650', 'Hayabusa', 'DR-Z400SM', 'GSX-S1000', 'Burgman 400'],

    // American Cruiser & Adventure
    'Harley-Davidson' => ['Street Glide', 'Iron 883', 'Fat Boy', 'Sportster S', 'Pan America 1250', 'Low Rider S'],
    'Indian' => ['Chief', 'Scout', 'Challenger', 'FTR R Carbon', 'Springfield'],

    // Major European Brands
    'BMW' => ['S 1000 RR', 'R 1250 GS', 'F 900 R', 'G 310 GS', 'K 1600 GT', 'R 18', 'CE 04'],
    'Ducati' => ['Panigale V4', 'Monster', 'Multistrada V4', 'Scrambler Icon', 'Diavel 1260', 'Streetfighter V4'],
    'KTM' => ['1290 Super Duke R', '390 Duke', '890 Adventure', 'RC 390', 'EXC 300', '790 Adventure'],
    'Triumph' => ['Street Triple', 'Bonneville T120', 'Tiger 900', 'Speed Twin', 'Rocket 3', 'Trident 660'],
    'Aprilia' => ['RSV4', 'Tuono 660', 'Tuareg 660', 'SR GT 200', 'RS 660'],
    'Moto Guzzi' => ['V7 Stone', 'V85 TT', 'California 1400', 'V100 Mandello'],
    'Husqvarna' => ['Norden 901', 'Svartpilen 401', 'Vitpilen 701'],
    'Royal Enfield' => ['Interceptor 650', 'Classic 350', 'Himalayan', 'Meteor 350', 'Hunter 350'],
    'Vespa' => ['Primavera 125', 'GTS 300', 'Sprint 150', 'Elettrica'],
    'CFMoto' => ['450SR', '800NK', '700CL-X', '450SS', '650NK'],
    'Benelli' => ['Leoncino 500', 'TRK 502', 'Imperiale 400', '752 S', 'TNT 125'],
    'MV Agusta' => ['Brutale 800', 'F3 800', 'Superveloce 800', 'Dragster 800'],

    // Niche & Exotic European
    'Norton' => ['Commando 961', 'Atlas', 'V4 RR'],
    'Brough Superior' => ['SS100', 'SS80'],
    'Bimota' => ['Tesi H2', 'DB5', 'KB4'],
    'Cagiva' => ['Raptor 650', 'Mito 125'],
    'Derbi' => ['GPR 50', 'Senda DRD 50'],
    'Gilera' => ['Runner 200', 'Nexus 500'],

    // Electric & Alternative Propulsion
    'Zero Motorcycles' => ['SR/S', 'FXE', 'DSR/X', 'S', 'DS'],
    'Energica' => ['Ego+', 'EsseEsse9+', 'Experia', 'Eva Ribelle'],
    'LiveWire' => ['S2 Del Mar', 'One'],
    'Lightning Motorcycles Corp.' => ['LS-218', 'Strike'],
    'Curtiss Motorcycles (formerly Confederate)' => ['One', 'Wraith'],
    'Arc Vehicle Ltd' => ['Vector'],
    'Damon Motors Inc.' => ['Hypersport'],
    'Cake 0 Emission AB' => ['Ösa', 'Kalk'],
    'Sur-Ron' => ['Light Bee X', 'Storm Bee'],
    'Stark Future S.L.' => ['Varg'],
    'Super Soco' => ['TS', 'TC Max', 'CPx'],
    'Niu Technologies' => ['NQi GT', 'MQi+ Sport'],
    'Silence Urban Ecomobility' => ['S01', 'S02'],

    // Chinese & Asian Brands
    'Voge' => ['Valico 500DS', 'ER10', '500R'],
    'Zontes' => ['310 R', '310 X'],
    'SWM Motorcycles' => ['RS 300 R', 'Superdual T'],
    'TVS' => ['Apache RTR 200', 'Jupiter', 'Apache RR 310'],
    'Bajaj' => ['Pulsar NS200', 'Dominar 400', 'Avenger Cruise 220'],
    'Hero MotoCorp' => ['Splendor Plus', 'Xtreme 160R', 'Passion Pro'],
    'Kymco' => ['Like 150', 'AK 550', 'Super 8 150'],
    'SYM' => ['Jet 14', 'Wolf T2', 'Fiddle III'],

    // ATV/UTV Manufacturers (some with road-legal models)
    'Can-Am' => ['Spyder F3', 'Ryker 900', 'Maverick X3', 'Spyder RT'],
    'Polaris' => ['Slingshot', 'Sportsman 570', 'RZR XP Turbo'],
    'Segway Powersports (Segway-Ninebot)' => ['X260', 'X160'],

    // Defunct or Less Common
    'Victory Motorcycles' => ['Judge', 'Octane', 'Hammer S'],
    'Buell Motorcycle Company' => ['XB12S', 'Lightning XB9', '1125R'],
    'Alta Motors (defunct)' => ['Redshift MX', 'Redshift EX'],
];

        foreach ($brandsWithModels as $brandName => $models) {
            $motorcycleBrand = MotorcycleBrand::firstOrCreate(['name' => $brandName]);
            foreach ($models as $modelName) {
                if (!empty($modelName)) {
                    MotorcycleModel::firstOrCreate([
                        'motorcycle_brand_id' => $motorcycleBrand->id,
                        'name' => $modelName,
                    ]);
                }
            }
        }
    }
}
