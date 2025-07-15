<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CarModel; // Υποθέτω έχεις μοντέλο για τα μοντέλα αυτοκινήτων
use Illuminate\Support\Facades\DB;

class CarController extends Controller
{
    public function getModelsByBrand($brand)
    {
        // Αναζήτηση μοντέλων που ανήκουν σε συγκεκριμένη μάρκα
        // Υποθέτουμε ότι το μοντέλο CarModel έχει πεδίο 'brand_name'

        $models = CarModel::where('brand_name', $brand)
            ->select('name')
            ->orderBy('name')
            ->get();

        return response()->json($models);
    }
}
