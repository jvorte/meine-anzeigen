<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

// Import ALL your ad models here:
use App\Models\Car;
use App\Models\Part;
use App\Models\Electronic;
use App\Models\HouseholdItem;
use App\Models\RealEstate;
use App\Models\Service;
use App\Models\Boat;
use App\Models\Other;
use App\Models\MotorradAd;
use App\Models\CommercialVehicle;
use App\Models\Camper;
use App\Models\UsedVehiclePart; // Ensure this is the correct model for fahrzeugeteile, if different from Part

class DashboardController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        $adsByCategory = [
            'cars' => Car::with('images')->orderBy('created_at', 'desc')->limit(4)->get(),
            'vehicles-parts' => UsedVehiclePart::with('images')->orderBy('created_at', 'desc')->limit(4)->get(),
            'electronics' => Electronic::with('images')->orderBy('created_at', 'desc')->limit(4)->get(),
            'household' => HouseholdItem::with('images')->orderBy('created_at', 'desc')->limit(4)->get(),
            'real-estate' => RealEstate::with('images')->orderBy('created_at', 'desc')->limit(4)->get(),
            'services' => Service::with('images')->orderBy('created_at', 'desc')->limit(4)->get(),
            'boats' => Boat::with('images')->orderBy('created_at', 'desc')->limit(4)->get(),
            'others' => Other::with('images')->orderBy('created_at', 'desc')->limit(4)->get(),
            'motorcycles' => MotorradAd::with('images')->orderBy('created_at', 'desc')->limit(4)->get(),
            'commercial-vehicle' => CommercialVehicle::with('images')->orderBy('created_at', 'desc')->limit(4)->get(),
            'campers' => Camper::with('images')->orderBy('created_at', 'desc')->limit(4)->get(),
        ];

        return view('dashboard', [
            'categories' => $categories,
            'adsByCategory' => $adsByCategory,
        ]);
    }
}
