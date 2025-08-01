<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CamperModel; // Make sure to import

class CamperModelSeeder extends Seeder
{
    public function run(): void
    {
        // Models for Adria (assuming CamperBrand ID 1)
        CamperModel::create(['camper_brand_id' => 1, 'name' => 'Adora', 'slug' => 'adora']);
        CamperModel::create(['camper_brand_id' => 1, 'name' => 'Coral', 'slug' => 'coral']);

        // Models for Bürstner (assuming CamperBrand ID 2)
        CamperModel::create(['camper_brand_id' => 2, 'name' => 'Lyseo', 'slug' => 'lyseo']);
        CamperModel::create(['camper_brand_id' => 2, 'name' => 'Ixeo', 'slug' => 'ixeo']);

        // *** IMPORTANT: Add models for Brand ID 8 (Pilote, or whatever your ID 8 is) ***
        CamperModel::create(['camper_brand_id' => 8, 'name' => 'Pacific 690', 'slug' => 'pacific-690']);
        CamperModel::create(['camper_brand_id' => 8, 'name' => 'Foxy Van V600', 'slug' => 'foxy-van-v600']);
        CamperModel::create(['camper_brand_id' => 8, 'name' => 'Explorateur G740', 'slug' => 'explorateur-g740']);

        // Add more models for other brands as needed
        // CamperModel::create(['camper_brand_id' => [ID OF KNAUS], 'name' => 'Sky Traveller', 'slug' => 'sky-traveller']);
        // ...
    }
}