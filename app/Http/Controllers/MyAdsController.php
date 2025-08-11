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
{ public function index()
{
    $userId = Auth::id();

    $carAds = Car::where('user_id', $userId)->latest()->get();
    $boats = Boat::where('user_id', $userId)->latest()->get();
    $electronicAds = Electronic::where('user_id', $userId)->latest()->get();
    $householdAds = HouseholdItem::where('user_id', $userId)->latest()->get();
    $realEstates = RealEstate::where('user_id', $userId)->latest()->get();
    $services = Service::where('user_id', $userId)->latest()->get();
    $others = Other::where('user_id', $userId)->latest()->get();
    $motorcycles = MotorradAd::where('user_id', $userId)->latest()->get();
    $commercialVehicles = CommercialVehicle::where('user_id', $userId)->latest()->get();
    $campers = Camper::where('user_id', $userId)->latest()->get();
    $usedVehicleParts = UsedVehiclePart::where('user_id', $userId)->latest()->get();

    return view('my-ads.index', compact(
        'carAds', 'boats', 'electronicAds', 'householdAds', 'realEstates', 'services',
        'others', 'motorcycles', 'commercialVehicles', 'campers', 'usedVehicleParts'
    ));
}

}
