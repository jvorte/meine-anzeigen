<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
// Import all specific ad type controllers
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\PartController;
use App\Http\Controllers\ElectronicsController;
use App\Http\Controllers\HouseholdController;
use App\Http\Controllers\RealEstateController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\BoatController;
use App\Http\Controllers\OtherController;
use App\Http\Controllers\MotorradAdController; 
use App\Http\Controllers\CommercialVehicleController;
use App\Http\Controllers\CamperController;
use App\Http\Controllers\UsedVehiclePartController;




/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// AJAX response for models (e.g., via fetch from Alpine.js)
Route::get('/models/{brandId}', function ($brandId) {
    return \App\Models\CarModel::where('brand_id', $brandId)->pluck('name', 'id');
});

// Main Dashboard/Home Page
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


// Routes with authentication
Route::middleware(['auth'])->group(function () {
    // Ad submission routes for specific categories

    // Motorrad Ad Routes (KEEP ONLY THIS BLOCK FOR MOTORRAD ADS)
    Route::get('/ads/motorrad/create', [MotorradAdController::class, 'create'])->name('ads.motorrad.create');
    Route::post('/ads/motorrad', [MotorradAdController::class, 'store'])->name('ads.motorrad.store');
    Route::get('/ads/motorrad/{motorradAd}', [MotorradAdController::class, 'show'])->name('ads.motorrad.show');

       // Commercial Vehicle Ad Routes
    Route::get('/ads/commercial-vehicles/create', [CommercialVehicleController::class, 'create'])->name('ads.commercial-vehicles.create');
    Route::post('/ads/commercial-vehicles', [CommercialVehicleController::class, 'store'])->name('ads.commercial-vehicles.store');
    // Optional: Route for showing a single ad
    Route::get('/ads/commercial-vehicles/{commercialVehicle}', [CommercialVehicleController::class, 'show'])->name('ads.commercial-vehicles.show');

   // Camper Ad Creation and Storage Routes
    // This route displays the form to create a new camper ad.
    Route::get('/ads/camper/create', [CamperController::class, 'create'])->name('ads.camper.create');
    // This route handles the form submission to store a new camper ad.
    Route::post('/ads/camper', [CamperController::class, 'store'])->name('ads.camper.store');

       // Used Vehicle Part Ad Routes
    Route::get('/ads/used-vehicle-parts/create', [UsedVehiclePartController::class, 'create'])->name('ads.used-vehicle-parts.create');
    Route::post('/ads/used-vehicle-parts', [UsedVehiclePartController::class, 'store'])->name('ads.used-vehicle-parts.store');
    // Optional: Route for showing a single ad
    Route::get('/ads/used-vehicle-parts/{usedVehiclePart}', [UsedVehiclePartController::class, 'show'])->name('ads.used-vehicle-parts.show');



    Route::post('/vehicles', [VehicleController::class, 'store'])->name('vehicles.store');
    Route::post('/parts', [PartController::class, 'store'])->name('parts.store');
    Route::get('/ads/parts/create', [PartController::class, 'create'])->name('ads.parts.create');

    Route::get('/ads/electronics/create', [ElectronicsController::class, 'create'])->name('ads.electronics.create');
    Route::post('/electronics', [ElectronicsController::class, 'store'])->name('electronics.store');

    Route::get('/ads/household/create', [HouseholdController::class, 'create'])->name('ads.household.create');
    Route::post('/household', [HouseholdController::class, 'store'])->name('household.store');

    Route::get('/ads/real-estate/create', [RealEstateController::class, 'create'])->name('ads.realestate.create');
    Route::post('/realestate', [RealEstateController::class, 'store'])->name('realestate.store');

    Route::get('/ads/services/create', [ServiceController::class, 'create'])->name('ads.services.create');
    Route::post('/services', [ServiceController::class, 'store'])->name('services.store');

    Route::get('/ads/boats/create', [BoatController::class, 'create'])->name('ads.boats.create');
    Route::post('/boote', [BoatController::class, 'store'])->name('boote.store');

    Route::get('/ads/others/create', [OtherController::class, 'create'])->name('ads.others.create');
    Route::post('/sonstiges', [OtherController::class, 'store'])->name('sonstiges.store');

    // Ad creation form route
    Route::get('/ads/create', [AdController::class, 'create'])->name('ads.create');

    // User profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// Fallback for generic ad show (if ads are not strictly categorized by URL)
Route::get('/ads/{ad}', [AdController::class, 'show'])->name('ads.show');


Route::get('/ads/autos/create', [VehicleController::class, 'createAutos'])->name('ads.autos.create');
Route::post('/ads/fahrzeuge', [VehicleController::class, 'storeFahrzeuge'])->name('ads.fahrzeuge.store');

Route::get('/ads/wohnmobile/create', [VehicleController::class, 'createWohnmobile'])->name('ads.wohnmobile.create');
Route::post('/ads/wohnmobile', [VehicleController::class, 'storeWohnmobile'])->name('ads.wohnmobile.store');


// SHOW Public routes
// Generic category show route - This handles /categories/{slug} for all categories
Route::get('/categories/{slug}', [CategoryController::class, 'show'])->name('categories.show');

// Specific ad detail pages for each model type
Route::prefix('categories')->name('categories.')->group(function () {
    Route::get('/fahrzeuge/{vehicle}', [VehicleController::class, 'show'])->name('fahrzeuge.show');
    Route::get('/boote/{boat}', [BoatController::class, 'show'])->name('boote.show');
    Route::get('/fahrzeugeteile/{part}', [PartController::class, 'show'])->name('fahrzeugeteile.show');
    Route::get('/elektronik/{electronic}', [ElectronicsController::class, 'show'])->name('elektronik.show');
    Route::get('/haushalt/{household}', [HouseholdController::class, 'show'])->name('haushalt.show');
    Route::get('/immobilien/{realEstate}', [RealEstateController::class, 'show'])->name('immobilien.show');
    Route::get('/dienstleistungen/{service}', [ServiceController::class, 'show'])->name('dienstleistungen.show');
    Route::get('/sonstiges/{other}', [OtherController::class, 'show'])->name('sonstiges.show');
});

// Auth scaffolding routes (login, register, etc.)
require __DIR__ . '/auth.php';