<?php


namespace App\Http\Controllers;



// --- Import all your specific ad type models ---

use App\Models\MotorradAd;
use App\Models\Boat;
use App\Models\Camper;
use App\Models\CommercialVehicle;
use App\Models\Electronic;
use App\Models\HouseholdItem;
use App\Models\RealEstate;
use App\Models\Service;
use App\Models\UsedVehiclePart;
use App\Models\Other; // Ensure you have this model for 'others' table

// --- Also import other general search models if relevant ---

use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;

use App\Models\Ad;
use Illuminate\Support\Facades\Log;
use App\Models\Car;
class AdController extends Controller
{



 public function search(Request $request)
    {
        $query = $request->input('query');
        $searchTerm = '%' . $query . '%'; // Prepare the search term for 'LIKE' queries
        
        // Initialize an empty array to store results from different tables
        $results = [
            'vehicles' => collect(),
            'motorrad_ads' => collect(),
            'boats' => collect(),
            'campers' => collect(),
            'commercial_vehicles' => collect(),
            'electronics' => collect(),
            'household_items' => collect(),
            'real_estates' => collect(),
            'services' => collect(),
            'used_vehicle_parts' => collect(),
            'others' => collect(),
            'categories' => collect(), // For searching category names
            'users' => collect(),     // For searching user names
        ];

        // Only perform searches if there's an actual query
        if ($query) {
            // --- Search each ad type table ---
            $results['cars'] = Car::where('title', 'like', $searchTerm)
                                         ->orWhere('description', 'like', $searchTerm)
                                         ->get();

            $results['motorrad_ads'] = MotorradAd::where('title', 'like', $searchTerm)
                                                 ->orWhere('description', 'like', $searchTerm)
                                                 ->get();

            $results['boats'] = Boat::where('title', 'like', $searchTerm)
                                    ->orWhere('description', 'like', $searchTerm)
                                    ->get();
            
            $results['campers'] = Camper::where('title', 'like', $searchTerm)
                                        ->orWhere('description', 'like', $searchTerm)
                                        ->get();

            $results['commercial_vehicles'] = CommercialVehicle::where('title', 'like', $searchTerm)
                                                              ->orWhere('description', 'like', $searchTerm)
                                                              ->get();

            $results['electronics'] = Electronic::where('title', 'like', $searchTerm)
                                                ->orWhere('description', 'like', $searchTerm)
                                                ->get();

            $results['household_items'] = HouseholdItem::where('title', 'like', $searchTerm)
                                                       ->orWhere('description', 'like', $searchTerm)
                                                       ->get();
            
            $results['real_estates'] = RealEstate::where('title', 'like', $searchTerm)
                                                 ->orWhere('description', 'like', $searchTerm)
                                                 ->get();

            $results['services'] = Service::where('title', 'like', $searchTerm)
                                          ->orWhere('description', 'like', $searchTerm)
                                          ->get();

            $results['used_vehicle_parts'] = UsedVehiclePart::where('title', 'like', $searchTerm)
                                                           ->orWhere('description', 'like', $searchTerm)
                                                           ->get();

            // IMPORTANT: Ensure 'others' table has 'title' and 'description' columns,
            // or adjust these column names if it uses different ones.
            $results['others'] = Other::where('title', 'like', $searchTerm)
                                      ->orWhere('description', 'like', $searchTerm)
                                      ->get();
            
            // --- Search other general tables ---
            $results['categories'] = Category::where('name', 'like', $searchTerm)->get();
            $results['users'] = User::where('name', 'like', $searchTerm)->get(); // Assuming users have a 'name'
        }

        // Pass the original query and the combined results to the view
        return view('ads.search-results', [
            'query' => $query,
            'results' => $results, // This array contains all your found items
        ]);
    }





public function create()
{
    $categories = Category::all();
    return view('ads.create', compact('categories'));
}    

    public function show(Ad $ad)
    {
        return view('ads.show', compact('ad'));
    }

    public function index()
    {
        $ads = Ad::latest()->paginate(10);
        return view('ads.index', compact('ads'));
    }
}