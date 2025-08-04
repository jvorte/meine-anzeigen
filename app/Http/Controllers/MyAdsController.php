<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\Electronic;
use App\Models\RealEstate;
use App\Models\Service;


class MyAdsController extends Controller
{ public function index()
    {
        $userId = Auth::id();

        $carAds = Car::where('user_id', $userId)->latest()->get();
        $electronicAds = Electronic::where('user_id', $userId)->latest()->get();
        $realEstates = RealEstate::where('user_id', $userId)->latest()->get();
        $services = Service::where('user_id', $userId)->latest()->get();

        return view('my-ads.index', compact('carAds', 'electronicAds', 'realEstates', 'services'));
    }
}
