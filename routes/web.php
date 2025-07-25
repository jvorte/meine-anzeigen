<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
// Removed VehicleController as CarController is taking its place for "cars"
use App\Http\Controllers\PartController;
use App\Http\Controllers\ElectronicController;
use App\Http\Controllers\RealEstateController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\BoatController;
use App\Http\Controllers\OtherController;
use App\Http\Controllers\MotorradAdController;
use App\Http\Controllers\CommercialVehicleController;
use App\Http\Controllers\CamperController;
use App\Http\Controllers\UsedVehiclePartController;
use App\Http\Controllers\HouseholdItemController;
use App\Http\Controllers\CarController; // Keeping CarController as the dedicated controller for cars
use App\Models\Brand;
use Illuminate\Http\Request;

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

// --- PUBLIC ROUTES ---
Route::get('/ads/search', [AdController::class, 'search'])->name('ads.search');

// AJAX response for electronic models
Route::get('/electronic-models/{brandId}', function ($brandId) {
    return App\Models\ElectronicModel::where('brand_id', $brandId)->orderBy('name')->pluck('name', 'id');
})->name('ajax.get-electronic-models');

// Main Dashboard/Home Page
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Generic category show route - This handles /categories/{slug} for all categories
Route::get('/categories/{slug}', [CategoryController::class, 'show'])->name('categories.show');

// Specific ad detail pages for each model type (Publicly accessible)
Route::prefix('categories')->name('categories.')->group(function () {
    // Changed 'fahrzeuge' to 'cars' in URI and name, and using CarController
    Route::get('/cars/{car}', [CarController::class, 'show'])->name('cars.show');
    Route::get('/boote/{boat}', [BoatController::class, 'show'])->name('boote.show');
    Route::get('/fahrzeugeteile/{usedVehiclePart}', [UsedVehiclePartController::class, 'show'])->name('fahrzeugeteile.show');
    Route::get('/elektronik/{electronic}', [ElectronicController::class, 'show'])->name('elektronik.show');
    Route::get('/haushalt/{householdItem}', [HouseholdItemController::class, 'show'])->name('haushalt.show');
    Route::get('/immobilien/{realEstate}', [RealEstateController::class, 'show'])->name('immobilien.show');
    Route::get('/dienstleistungen/{service}', [ServiceController::class, 'show'])->name('dienstleistungen.show');
    Route::get('/sonstiges/{other}', [OtherController::class, 'show'])->name('sonstiges.show');
    Route::get('/motorrad/{motorradAd}', [MotorradAdController::class, 'show'])->name('motorrad.show');
    Route::get('/nutzfahrzeuge/{commercialVehicle}', [CommercialVehicleController::class, 'show'])->name('nutzfahrzeuge.show');
    Route::get('/wohnmobile/{camper}', [CamperController::class, 'show'])->name('wohnmobile.show');
});


// --- AUTHENTICATED ROUTES ---
Route::middleware(['auth'])->group(function () {

    // User profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Main Ads listing
    Route::get('/ads', [AdController::class, 'index'])->name('ads.index');

    // Generic Ad Creation (if this is a selection page for ad type)
    Route::get('/ads/create', [AdController::class, 'create'])->name('ads.create');

    // Fallback for generic ad show (if ads are not strictly categorized by URL)
    Route::get('/ads/{ad}', [AdController::class, 'show'])->name('ads.show');

    // --- Specific Ad Type Creation/Storage Routes ---

    // Cars (formerly 'autos' and 'fahrzeuge' for creation/storage)
    // Assuming createAutos and storeFahrzeuge methods are now simply 'create' and 'store' in CarController
    Route::get('/ads/cars/create', [CarController::class, 'create'])->name('ads.cars.create');
    Route::post('/ads/cars', [CarController::class, 'store'])->name('ads.cars.store'); // Standardized URI and name for car storage

    // Motorrad Ads
    Route::get('/ads/motorrad/create', [MotorradAdController::class, 'create'])->name('ads.motorrad.create');
    Route::post('/ads/motorrad', [MotorradAdController::class, 'store'])->name('ads.motorrad.store');

    // Commercial Vehicles
    Route::get('/ads/commercial-vehicles/create', [CommercialVehicleController::class, 'create'])->name('ads.commercial-vehicles.create');
    Route::post('/ads/commercial-vehicles', [CommercialVehicleController::class, 'store'])->name('ads.commercial-vehicles.store');

    // Campers
    Route::get('/ads/camper/create', [CamperController::class, 'create'])->name('ads.camper.create');
    Route::post('/ads/camper', [CamperController::class, 'store'])->name('ads.camper.store');

    // Used Vehicle Parts
    Route::get('/ads/used-vehicle-parts/create', [UsedVehiclePartController::class, 'create'])->name('ads.used-vehicle-parts.create');
    Route::post('/ads/used-vehicle-parts', [UsedVehiclePartController::class, 'store'])->name('ads.used-vehicle-parts.store');

    // Boats
    Route::get('/ads/boats/create', [BoatController::class, 'create'])->name('ads.boats.create');
    Route::post('/ads/boats', [BoatController::class, 'store'])->name('ads.boats.store');

    // Electronics
    Route::get('/ads/electronics/create', [ElectronicController::class, 'create'])->name('ads.electronics.create');
    Route::post('/ads/electronics', [ElectronicController::class, 'store'])->name('ads.electronics.store');

    // Household Items
    Route::get('/ads/household/create', [HouseholdItemController::class, 'create'])->name('ads.household.create');
    Route::post('/ads/household', [HouseholdItemController::class, 'store'])->name('ads.household.store');

    // Real Estate
    Route::get('/ads/real-estate/create', [RealEstateController::class, 'create'])->name('ads.realestate.create');
    // Consider if this should be /ads/real-estate for consistency or if /realestate is a top-level resource
    Route::post('/realestate', [RealEstateController::class, 'store'])->name('ads.realestate.store');

    // Services - Fixed typo 'servises' to 'services'
    Route::get('/ads/services/create', [ServiceController::class, 'create'])->name('ads.services.create');
    // Consider if this should be /ads/services for consistency or if /services is a top-level resource
    Route::post('/services', [ServiceController::class, 'store'])->name('ads.services.store');

    // Others
    Route::get('/ads/others/create', [OtherController::class, 'create'])->name('ads.others.create');
    // Consider if this should be /ads/others for consistency or if /others is a top-level resource
    Route::post('/others', [OtherController::class, 'store'])->name('ads.others.store');

    // --- Remaining PartController routes ---
    // The previous '/vehicles' route was likely intended for cars. If so, it's replaced by '/ads/cars' or '/cars'.
    // If 'vehicles.store' was a generic catch-all, you might need to reconsider its purpose.
    // For now, I'm assuming it's part of the 'Car' flow or is generic but less critical.
    // Removed the conflicting '/ads/fahrzeuge' route.
    Route::post('/parts', [PartController::class, 'store'])->name('parts.store');
    Route::get('/ads/parts/create', [PartController::class, 'create'])->name('ads.parts.create');

});

// Auth scaffolding routes (login, register, etc.) - ALWAYS keep this at the very end
require __DIR__ . '/auth.php';