<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\Electronic;
use App\Models\RealEstate;
use App\Models\Service;
use App\Models\UsedVehiclePart;
use App\Models\Boat;
use App\Models\HouseholdItem;
use App\Models\Other;
use App\Models\MotorradAd;
use App\Models\CommercialVehicle;
use App\Models\Camper;





class MyAdsController extends Controller
{
    
// In app/Http/Controllers/MyAdsController.php

// In app/Http/Controllers/MyAdsController.php

public function index()
{
    $userId = Auth::id();

    // Eager load the 'images' relationship for all models.
    $carAds = Car::with('images')->where('user_id', $userId)->latest()->get();
    $boats = Boat::with('images')->where('user_id', $userId)->latest()->get();
    $electronicAds = Electronic::with('images')->where('user_id', $userId)->latest()->get();
    $householdAds = HouseholdItem::with('images')->where('user_id', $userId)->latest()->get();
    $realEstates = RealEstate::with('images')->where('user_id', $userId)->latest()->get();
    $services = Service::with('images')->where('user_id', $userId)->latest()->get();
    $others = Other::with('images')->where('user_id', $userId)->latest()->get();
    $motorcycles = MotorradAd::with('images')->where('user_id', $userId)->latest()->get();
    $commercialVehicles = CommercialVehicle::with('images')->where('user_id', $userId)->latest()->get();
    $campers = Camper::with('images')->where('user_id', $userId)->latest()->get();
    $usedVehicleParts = UsedVehiclePart::with('images')->where('user_id', $userId)->latest()->get();

    return view('my-ads.index', compact(
        'carAds', 'boats', 'electronicAds', 'householdAds', 'realEstates', 'services',
        'others', 'motorcycles', 'commercialVehicles', 'campers', 'usedVehicleParts'
    ));
}


    public function favorites()
    {
        $user = Auth::user();
        
        // This line gets all the favorite records from the `favorites` table for the user.
        $favorites = $user->favorites;

        // Pass the favorites to the view.
        return view('my-ads.favorites', compact('favorites'));
    }

}
