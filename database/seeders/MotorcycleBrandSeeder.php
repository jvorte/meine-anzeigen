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

    // Brands που είχες κενά, τώρα με 3-5 μοντέλα το καθένα
    'Norton' => ['Commando 961', 'Atlas', 'Dominor SS', 'V4 RR'],
    'Brough Superior' => ['SS100', 'SS80', 'SS100 Atlantic'],
    'Can-Am' => ['Spyder F3', 'Ryker 900', 'Maverick X3'],
    'Polaris' => ['Sportsman 570', 'RZR XP Turbo', 'Indian Scout'],
    'TVS' => ['Apache RTR 200', 'Jupiter', 'NTORQ 125', 'Apache RR 310'],
    'Bajaj' => ['Pulsar NS200', 'Dominar 400', 'Avenger Cruise 220'],
    'Hero MotoCorp' => ['Splendor Plus', 'Xtreme 160R', 'Passion Pro'],
    'Mahindra' => ['Centuro', 'Gusto', 'MOJO'],
    'Hyosung' => ['GT650R', 'Aquila Pro', 'GD250N'],
    'Kymco' => ['Like 150', 'AK 550', 'Super 8 150'],
    'SYM' => ['Jet 14', 'Wolf T2', 'Fiddle III'],
    'Loncin' => ['LX250GY-3', 'CR9', 'CR9 250'],
    'Zongshen' => ['RX3', 'RX5', 'Z1'],
    'Qianjiang' => ['QJ250-3', 'QJ300-4'],
    'Garelli' => ['GSM 125', 'GSP 125', 'Luna'],

    'Malaguti' => ['Drakon 125', 'Dune 125', 'Mission 125'],
    'Fantic' => ['Caballero 500', 'Issimo 125', 'Chimera 250'],
    'Scorpa' => ['T-Ride 250', 'T-Ride 125'],
    'Vertigo' => ['Combat 300', 'Stark'],
    'Montesa' => ['Cota 4RT', 'Cota 300RR'],

    'Cagiva' => ['Raptor 650', 'Navigator 1000', 'Elefant 900'],
    'Derbi' => ['GPR 50', 'Senda DRD 50'],
    'Gilera' => ['Runner 200', 'Nexus 500'],
    'Laverda' => ['SFC 1000', 'V6'],
    'Bimota' => ['Tesi H2', 'DB5'],

    'Victory Motorcycles' => ['Judge', 'Octane', 'Hammer S'],
    'EBR Motorcycles' => ['1190 RX', '1190 SX'],
    'Buell Motorcycle Company' => ['XB12S', 'Lightning XB9'],

    'Alta Motors (defunct)' => ['Redshift MX', 'Redshift EX'],
    'Lightning Motorcycles Corp.' => ['LS-218', 'Strike'],
    'Curtiss Motorcycles (formerly Confederate)' => ['One', 'Wraith'],

    'Arc Vehicle Ltd' => ['Vector', 'Fox'],
    'Damon Motors Inc.' => ['Hypersport'],
    'Sondors Inc.' => ['Metacycle'],

    'Cake 0 Emission AB' => ['Ösa', 'Cake Kalk'],

    'Super Soco (VMoto Soco Group)' => ['TS', 'TC Max', 'CPx'],
    'Niu Technologies' => ['NQi GT', 'MQi+ Sport'],
    'Silence Urban Ecomobility' => ['S01', 'S02'],

    'Horwin (Horwin Europe GmbH)' => ['CR6', 'EK3'],
    'Voge (Loncin Motor Co., Ltd.)' => ['Valico 500DS', 'ER10'],
    'Brixton Motorcycles (KSR Group GmbH)' => ['Crossfire 500', 'Fighter 500'],
    'Zontes (Guangdong Tayo Motorcycle Technology Co., Ltd.)' => ['310 R', '310 X'],

    'Macbor (Motana S.A.)' => ['Shifter 125', 'Rockster 125'],
    'SWM Motorcycles' => ['RS 300 R', 'Superdual T'],
    'TM Racing S.p.A.' => ['EN 300 Fi', 'MX 250 Fi'],

    'AJP Motos' => ['PR7', 'PR4'],
    'Rieju S.A.' => ['Marathon 125', 'MR 300'],
    'Oset Bikes' => ['16.0 Racing', '24.0 Racing'],
    'Sur-Ron (Zhejiang Sur-Ron Technology Co., Ltd.)' => ['Light Bee X', 'Storm Bee'],

    'Stark Future S.L.' => ['Varg', 'Future'],
    'Volcon Inc.' => ['Grunt', 'Blackout'],
    'Kayo USA' => ['T4 250', 'CR3 125'],
    'Pitster Pro' => ['LXR 160', 'ZR 150'],

    'SSR Motorsports' => ['SR110', 'SR125'],
    'Apollo Motors' => ['Pro', 'Phantom'],
    'TaoTao USA' => ['ATM 50-A1', 'Thunder 110'],

    'Coleman Powersports' => ['CT100U', 'CT200U'],
    'Hisun Motors Corp., USA' => ['Sector 250', 'HS700'],
    'Massimo Motor Sports, LLC' => ['MB200', 'MSS250'],
    'Segway Powersports (Segway-Ninebot)' => ['X260', 'X160'],

    'CFMOTO Powersports (CFMOTO)' => ['ZForce 800', 'CForce 1000'],
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
