<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MotorcycleBrand; // Import your new MotorcycleBrand model

class MotorcycleBrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $motorcycleBrands = [
            'Honda', 'Yamaha', 'Kawasaki', 'Suzuki', 'Harley-Davidson',
            'BMW', 'Ducati', 'KTM', 'Triumph', 'Aprilia',
            'Moto Guzzi', 'Vespa', 'Piaggio', 'Royal Enfield', 'Indian',
            'Husqvarna', 'GasGas', 'Sherco', 'Beta', 'Zero Motorcycles',
            'Energica', 'LiveWire', 'CFMoto', 'Benelli', 'MV Agusta',
            'Norton', 'Brough Superior', 'Can-Am', 'Polaris', 'TVS',
            'Bajaj', 'Hero MotoCorp', 'Mahindra', 'Hyosung', 'Kymco',
            'SYM', 'Loncin', 'Zongshen', 'Qianjiang', 'Garelli',
            'Malaguti', 'Fantic', 'Scorpa', 'Vertigo', 'Montesa',
            'Cagiva', 'Derbi', 'Gilera', 'Laverda', 'Bimota',
            'Victory Motorcycles', 'EBR (Erik Buell Racing)', 'Buell',
            'Alta Motors', 'Lightning Motorcycles', 'Curtiss Motorcycles',
            'Arc Vehicle', 'Damon Motors Inc.', 'Sondors Inc.',
            'Cake 0 Emission AB', 'Super Soco (VMoto Soco Group)',
            'Niu Technologies', 'Silence Urban Ecomobility', 'Horwin (Horwin Europe GmbH)',
            'Voge (Loncin Motor Co., Ltd.)', 'Brixton Motorcycles (KSR Group GmbH)',
            'Zontes (Guangdong Tayo Motorcycle Technology Co., Ltd.)',
            'Macbor (Motana S.A.)', 'SWM Motorcycles', 'TM Racing S.p.A.',
            'AJP Motos', 'Rieju S.A.', 'Oset Bikes', 'Sur-Ron (Zhejiang Sur-Ron Technology Co., Ltd.)',
            'Stark Future S.L.', 'Volcon Inc.', 'Kayo USA', 'Pitster Pro',
            'SSR Motorsports', 'Apollo Motors', 'TaoTao USA',
            'Coleman Powersports', 'Hisun Motors Corp., USA',
            'Massimo Motor Sports, LLC', 'Segway Powersports (Segway-Ninebot)',
            'CFMOTO Powersports (CFMOTO)', 'Zero Motorcycles Inc.',
            'Energica Motor Company S.p.A.', 'LiveWire (Harley-Davidson)',
        ];

        foreach ($motorcycleBrands as $brandName) {
            MotorcycleBrand::firstOrCreate(['name' => $brandName]);
        }
    }
}