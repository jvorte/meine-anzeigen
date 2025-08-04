<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
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
use App\Http\Controllers\MessageController;
use App\Http\Controllers\MyAdsController;


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

Route::get('/commercial-vehicles/{commercialVehicle}', [App\Http\Controllers\CommercialVehicleController::class, 'show'])->name('commercial-vehicles.show');
// Specific ad detail pages for each model type (Publicly accessible)
Route::prefix('categories')->name('categories.')->group(function () {

    Route::get('/cars/{car}', [CarController::class, 'show'])->name('cars.show');
    Route::get('/boats/{boat}', [BoatController::class, 'show'])->name('boats.show');
    Route::get('/vehicles-parts/{usedVehiclePart}', [UsedVehiclePartController::class, 'show'])->name('vehicles-parts.show');
    Route::get('/electronics/{electronic}', [ElectronicController::class, 'show'])->name('electronics.show');
    Route::get('/household/{householdItem}', [HouseholdItemController::class, 'show'])->name('household.show');
    Route::get('/real-estate/{realEstate}', [RealEstateController::class, 'show'])->name('real-estate.show');
    Route::get('/services/{service}', [ServiceController::class, 'show'])->name('services.show');
    Route::get('/others/{other}', [OtherController::class, 'show'])->name('others.show');
    Route::get('/motorcycles/{motorradAd}', [MotorradAdController::class, 'show'])->name('motorcycles.show');
    Route::get('/commercial-vehicles/{commercialVehicle}', [CommercialVehicleController::class, 'show'])->name('commercial-vehicles.show');
    Route::get('/campers/{camper}', [CamperController::class, 'show'])->name('campers.show');

});



// 
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

    // Cars
    Route::get('/ads/cars/create', [CarController::class, 'create'])->name('ads.cars.create');
    Route::post('/ads/cars', [CarController::class, 'store'])->name('ads.cars.store');
    Route::get('/ads/cars/{car}/edit', [CarController::class, 'edit'])->name('ads.cars.edit');
    Route::put('/ads/cars/{car}', [CarController::class, 'update'])->name('ads.cars.update');
    Route::delete('/ads/cars/{car}', [CarController::class, 'destroy'])->name('ads.cars.destroy');
    Route::get('/ads/cars/{car}', [CarController::class, 'show'])->name('ads.cars.show');



    Route::get('/api/car-brands/{brandId}/models', [CarController::class, 'getModelsByBrand'])->name('api.car-brands.models');


    // Motorrad Ads
    Route::get('/ads/motorrad/create', [MotorradAdController::class, 'create'])->name('ads.motorrad.create');
    Route::post('/ads/motorrad', [MotorradAdController::class, 'store'])->name('ads.motorrad.store');

    // Route for fetching motorcycle models dynamically (for Alpine.js)
    Route::get('/motorcycle-models/{brandId}', [MotorradAdController::class, 'getModelsByBrand']);

    Route::get('/ads/motorrad/{motorradAd}', [MotorradAdController::class, 'show'])->name('ads.motorrad.show');
    Route::get('/ads/motorrad/{motorradAd}/edit', [MotorradAdController::class, 'edit'])->name('ads.motorrad.edit');
    Route::put('/ads/motorrad/{motorradAd}', [MotorradAdController::class, 'update'])->name('ads.motorrad.update');
    Route::delete('/ads/motorrad/{motorradAd}', [MotorradAdController::class, 'destroy'])->name('ads.motorrad.destroy');


    // Commercial Vehicles
    Route::prefix('ads/commercial-vehicles')->name('ads.commercial-vehicles.')->group(function () {
        Route::get('/create', [CommercialVehicleController::class, 'create'])->name('create');
        Route::post('/', [CommercialVehicleController::class, 'store'])->name('store');
        Route::get('/{commercialAd}/edit', [CommercialVehicleController::class, 'edit'])->name('edit');
        Route::put('/{commercialAd}', [CommercialVehicleController::class, 'update'])->name('update');
        Route::delete('/{ad}', [CommercialVehicleController::class, 'destroy'])->name('destroy');
        Route::get('/{commercialVehicle}', [CommercialVehicleController::class, 'show'])->name('show');
    });

    // Campers
    Route::get('/ads/camper/create', [CamperController::class, 'create'])->name('ads.camper.create');
    Route::post('/ads/camper', [CamperController::class, 'store'])->name('ads.camper.store');
    Route::get('/ads/camper/{camper}', [CamperController::class, 'show'])->name('ads.camper.show');
    Route::get('/ads/camper/{camper}/edit', [CamperController::class, 'edit'])->name('ads.camper.edit');
    Route::put('/ads/camper/{camper}', [CamperController::class, 'update'])->name('ads.camper.update');
    Route::delete('/ads/camper/{camper}', [CamperController::class, 'destroy'])->name('ads.camper.destroy');
Route::get('/api/camper-brands/{brandId}/models', [CamperController::class, 'getModelsByBrand'])->name('api.camper-brands.models');

    // Used Vehicle Parts
    Route::prefix('ads/used-vehicle-parts')->name('ads.used-vehicle-parts.')->group(function () {
        Route::get('/create', [UsedVehiclePartController::class, 'create'])->name('create');
        Route::post('/', [UsedVehiclePartController::class, 'store'])->name('store');
        Route::get('/{usedVehiclePart}', [UsedVehiclePartController::class, 'show'])->name('show'); // Added show route
        Route::get('/{usedVehiclePart}/edit', [UsedVehiclePartController::class, 'edit'])->name('edit'); // Added edit route
        Route::put('/{usedVehiclePart}', [UsedVehiclePartController::class, 'update'])->name('update'); // Added update route
        Route::delete('/{usedVehiclePart}', [UsedVehiclePartController::class, 'destroy'])->name('destroy'); // Added destroy route
    });
    // Boats
    Route::prefix('ads/boats')->name('ads.boats.')->group(function () {
        Route::get('/', [BoatController::class, 'index'])->name('index');
        Route::get('/create', [BoatController::class, 'create'])->name('create');
        Route::post('/', [BoatController::class, 'store'])->name('store');
        Route::get('/{boat}/edit', [BoatController::class, 'edit'])->name('edit');
        Route::put('/{boat}', [BoatController::class, 'update'])->name('update');
        Route::delete('/{boat}', [BoatController::class, 'destroy'])->name('destroy');
    });


    // Electronics (ADDITIONS START HERE)
    Route::get('/ads/electronics/create', [ElectronicController::class, 'create'])->name('ads.electronics.create');
    Route::post('/ads/electronics', [ElectronicController::class, 'store'])->name('ads.electronics.store');
    // ADDED: Edit route for Electronics
    Route::get('/ads/electronics/{electronic}/edit', [ElectronicController::class, 'edit'])->name('ads.electronics.edit');
    // ADDED: Update route for Electronics
    Route::put('/ads/electronics/{electronic}', [ElectronicController::class, 'update'])->name('ads.electronics.update');
    // ADDED: Destroy route for Electronics
    Route::delete('/ads/electronics/{electronic}', [ElectronicController::class, 'destroy'])->name('ads.electronics.destroy');
    // ADDED: Destroy Image route for Electronics (within ElectronicController)
    Route::delete('/ads/electronics/images/{electronicImage}', [ElectronicController::class, 'destroyImage'])->name('ads.electronics.images.destroy');

    // ---------------------------------------------------
    // Household Items
    Route::get('/ads/household/create', [HouseholdItemController::class, 'create'])->name('ads.household.create');
    Route::post('/ads/household', [HouseholdItemController::class, 'store'])->name('ads.household.store');
    Route::get('/ads/household-item/{householdItem}/edit', [HouseholdItemController::class, 'edit'])->name('ads.household-items.edit');
    Route::delete('/ads/household-item/{householdItem}/destroy', [HouseholdItemController::class, 'destroy'])->name('ads.household-items.destroy');
    Route::put('/ads/household-item/{householdItem}/update', [HouseholdItemController::class, 'update'])->name('ads.household-items.update');
    // ---------------------------------------------------


    // Real Estate
    Route::prefix('ads/real-estate')->name('ads.real-estate.')->group(function () {
        Route::get('/create', [RealEstateController::class, 'create'])->name('create');
        Route::post('/', [RealEstateController::class, 'store'])->name('store');
        Route::get('/{realEstate}', [RealEstateController::class, 'show'])->name('show');
        Route::get('/{realEstate}/edit', [RealEstateController::class, 'edit'])->name('edit');
        Route::put('/{realEstate}', [RealEstateController::class, 'update'])->name('update');
        Route::delete('/{realEstate}', action: [RealEstateController::class, 'destroy'])->name('destroy');

        
    });



    // Using Route::prefix and Route::name with dot notation for consistency
    Route::prefix('ads/services')->name('ads.services.')->group(function () {
        Route::get('/create', [ServiceController::class, 'create'])->name('create');
        Route::post('/', [ServiceController::class, 'store'])->name('store');
        Route::get('/{ad}/edit', [ServiceController::class, 'edit'])->name('edit'); // <-- THIS ONE
        Route::put('/{ad}', [ServiceController::class, 'update'])->name('update');
        Route::delete('/{ad}', [ServiceController::class, 'destroy'])->name('destroy');
        Route::get('/{service}', [ServiceController::class, 'show'])->name('show');
    });

    // Others
    Route::get('/ads/others/create', [OtherController::class, 'create'])->name('ads.others.create');
    // Consider if this should be /ads/others for consistency or if /others is a top-level resource
    Route::post('/others', [OtherController::class, 'store'])->name('ads.others.store');

    // Route::get('/ads/others', [OtherController::class, 'index'])->name('ads.others.index');
    // Route::get('/ads/others/create', [OtherController::class, 'create'])->name('ads.others.create'); // You already have this
    // Route::post('/ads/others', [OtherController::class, 'store'])->name('ads.others.store'); // You already have this
    Route::get('/ads/others/{other}/edit', [OtherController::class, 'edit'])->name('ads.others.edit');
    Route::put('/ads/others/{other}', [OtherController::class, 'update'])->name('ads.others.update');
    Route::delete('/ads/others/{other}', [OtherController::class, 'destroy'])->name('ads.others.destroy');
    Route::get('/ads/others/{other}', [OtherController::class, 'show'])->name('ads.others.show'); // You already have this

    // --- Remaining PartController routes ---
    Route::post('/parts', [PartController::class, 'store'])->name('parts.store');
    Route::get('/ads/parts/create', [PartController::class, 'create'])->name('ads.parts.create');

    Route::middleware('auth')->group(function () {
    Route::get('/messages', [App\Http\Controllers\MessageController::class, 'index'])->name('messages.index');
});

});

Route::middleware('auth')->group(function () {
    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/{conversation}', [MessageController::class, 'show'])->name('messages.show');
    Route::post('/messages/{conversation}', [MessageController::class, 'store'])->name('messages.store');
    Route::post('/messages/start', [MessageController::class, 'start'])->name('messages.start');
    Route::middleware('auth')->get('/messages/start/{ad}/{receiver}', [MessageController::class, 'startAndRedirect'])->name('messages.start.redirect');

});

Route::get('/meine-anzeigen', [MyAdsController::class, 'index'])->name('my-ads.index');


Route::middleware(['auth'])->group(function () {
    // ... existing profile routes
    Route::delete('/profile/photo', [ProfileController::class, 'destroyProfilePhoto'])->name('profile.destroy-profile-photo');
});

Route::get('/messages/create/{userId}', function ($userId) {
    // This is a placeholder. You would typically return a view with a form
    // for sending a message to the user with $userId.
    // Make sure you have a MessageController and a view for this.
    return view('messages.create', ['recipientId' => $userId]);
})->name('messages.create');

// Auth scaffolding routes (login, register, etc.) - ALWAYS keep this at the very end
require __DIR__ . '/auth.php';
