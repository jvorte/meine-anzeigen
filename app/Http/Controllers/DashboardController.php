<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; // Keep if you use it, otherwise can remove
use App\Models\Category;

// Import ALL your ad models here:
use App\Models\Vehicle;
use App\Models\Part; // Assuming this is for 'fahrzeugeteile'
use App\Models\Electronic;
use App\Models\HouseholdItem;
use App\Models\RealEstate;
use App\Models\Service;
use App\Models\Boat;
use App\Models\Other;
use App\Models\MotorradAd; // New: Import MotorradAd model
use App\Models\CommercialVehicle; // New: Import CommercialVehicle model
use App\Models\Camper; // New: Import Camper model
use App\Models\UsedVehiclePart; // Ensure this is the correct model for fahrzeugeteile, if different from Part

class DashboardController extends Controller
{
    public function index()
    {
        // Fetch categories for the header navigation
        $categories = Category::all();

        // Fetch a limited number of latest ads from each category model,
        // EAGER LOADING their 'images' relationship.
      $adsByCategory = [
            'fahrzeuge' => Vehicle::with('images')->orderBy('created_at', 'desc')->limit(4)->get(),
            'fahrzeugeteile' => Part::with('images')->orderBy('created_at', 'desc')->limit(4)->get(),
            'elektronik' => Electronic::with('images')->orderBy('created_at', 'desc')->limit(4)->get(),
            'haushalt' => HouseholdItem::with('images')->orderBy('created_at', 'desc')->limit(4)->get(),
            'immobilien' => RealEstate::with('images')->orderBy('created_at', 'desc')->limit(4)->get(),
            'dienstleistungen' => Service::with('images')->orderBy('created_at', 'desc')->limit(4)->get(),

            'boote' => Boat::with('images')->orderBy('created_at', 'desc')->limit(4)->get(),
            'sonstiges' => Other::with('images')->orderBy('created_at', 'desc')->limit(4)->get(),

            // NEWLY ADDED CATEGORIES:
            'motorrad' => MotorradAd::with('images')->orderBy('created_at', 'desc')->limit(4)->get(), // Slug 'motorrad'
            'nutzfahrzeuge' => CommercialVehicle::with('images')->orderBy('created_at', 'desc')->limit(4)->get(), // Slug 'nutzfahrzeuge'
            'wohnmobile' => Camper::with('images')->orderBy('created_at', 'desc')->limit(4)->get(), // Slug 'wohnmobile'
        ];
        return view('dashboard', [
            'categories' => $categories,
            'adsByCategory' => $adsByCategory,
        ]);
    }
}