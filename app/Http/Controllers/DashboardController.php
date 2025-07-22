<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicle;
use App\Models\Part;
use App\Models\Electronic;
use App\Models\HouseholdItem;
use App\Models\RealEstate;
use App\Models\Service;
use App\Models\Category; // Assuming you have a Category model for your navigation

class DashboardController extends Controller
{



       public function index()
    {
        // Fetch categories for the header navigation
        $categories = Category::all();

        // Fetch a limited number of latest ads from each category model.
        // We will keep them separate for grouped display.
        $adsByCategory = [
            'fahrzeuge' => Vehicle::orderBy('created_at', 'desc')->limit(4)->get(),
            'fahrzeugeteile' => Part::orderBy('created_at', 'desc')->limit(4)->get(),
            'elektronik' => Electronic::orderBy('created_at', 'desc')->limit(4)->get(),
            'haushalt' => HouseholdItem::orderBy('created_at', 'desc')->limit(4)->get(), // Corrected: Changed 'App->Models' to 'App\Models'
            'immobilien' => RealEstate::orderBy('created_at', 'desc')->limit(4)->get(),
            'dienstleistungen' => Service::orderBy('created_at', 'desc')->limit(4)->get(),
        ];

        return view('dashboard', [ // Assuming your main view is 'dashboard.blade.php'
            'categories' => $categories,
            'adsByCategory' => $adsByCategory, // Pass the associative array of ads
        ]);
    }
}
