<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\MyAdsController;
use App\Http\Controllers\AdController; // Kept for the generic create route and search

// Import all dedicated ad controllers
use App\Http\Controllers\CarController;
use App\Http\Controllers\BoatController;
use App\Http\Controllers\CamperController;
use App\Http\Controllers\CommercialVehicleController;
use App\Http\Controllers\ElectronicController;
use App\Http\Controllers\HouseholdItemController;
use App\Http\Controllers\MotorradAdController;
use App\Http\Controllers\OtherController;
use App\Http\Controllers\RealEstateController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\UsedVehiclePartController;


// --- PUBLIC ROUTES ---
//    Route::get('/ads/household/create', )->name('ads.household.create');

// Main Dashboard/Home Page
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard', [DashboardController::class, 'index']); // Added redirect for /dashboard to home

Route::get('/ads/camper', [App\Http\Controllers\CamperController::class, 'index'])->name('ads.camper.index');
// Ad Search
Route::get('/ads/search', [AdController::class, 'search'])->name('ads.search');
Route::get('ads/real-estate/{realEstate}', [RealEstateController::class, 'show'])
    ->name('ads.real-estate.show');

// Category Listing Pages (showing all ads in a category)
Route::prefix('categories')->name('categories.')->group(function () {
    Route::get('/cars', [CarController::class, 'index'])->name('cars.index');
    Route::get('/boats', [BoatController::class, 'index'])->name('boats.index');
    Route::get('/vehicles-parts', [UsedVehiclePartController::class, 'index'])->name('vehicles-parts.index');
    Route::get('/electronics', [ElectronicController::class, 'index'])->name('electronics.index');
    Route::get('/household', [HouseholdItemController::class, 'index'])->name('household.index');
    Route::get('/real-estate', [RealEstateController::class, 'index'])->name('real-estate.index');
    Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
    Route::get('/others', [OtherController::class, 'index'])->name('others.index');
    Route::get('/motorcycles', [MotorradAdController::class, 'index'])->name('motorcycles.index');
    Route::get('/commercial-vehicles', [CommercialVehicleController::class, 'index'])->name('commercial-vehicles.index');
    Route::get('/campers', [CamperController::class, 'index'])->name('campers.index');
});
 Route::get('/ads/household/create', [HouseholdItemController::class, 'create'])->name('ads.household.create'); 
// Ad Detail Pages (showing a single ad)
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
    Route::get('/commercial-vehicle/{commercialVehicle}', [CommercialVehicleController::class, 'show'])->name('commercial-vehicles.show');
    Route::get('/campers/{camper}', [CamperController::class, 'show'])->name('campers.show');
});
Route::get('/ads/household/{householdItem}', [HouseholdItemController::class, 'show'])->name('ads.household.show');

// AJAX Routes
Route::get('/electronic-models/{brandId}', function ($brandId) {
    return App\Models\ElectronicModel::where('brand_id', $brandId)->orderBy('name')->pluck('name', 'id');
})->name('ajax.get-electronic-models');
Route::get('/api/car-brands/{brandId}/models', [CarController::class, 'getModelsByBrand'])->name('api.car-brands.models');
Route::get('/motorcycle-models/{brandId}', [MotorradAdController::class, 'getModelsByBrand'])->name('ajax.get-motorcycle-models');
Route::get('/api/camper-brands/{brandId}/models', [CamperController::class, 'getModelsByBrand'])->name('api.camper-brands.models');


// --- AUTHENTICATED ROUTES ---
Route::middleware(['auth'])->group(function () {
    
    // User Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::delete('/profile/photo', [ProfileController::class, 'destroyProfilePhoto'])->name('profile.destroy-profile-photo');

    // My Ads
    Route::get('/meine-anzeigen', [MyAdsController::class, 'index'])->name('my-ads.index');

    // Ad Creation & Management (Resourceful Routes)
    Route::prefix('ads')->name('ads.')->group(function () {
        Route::get('/create', [AdController::class, 'create'])->name('create'); // Generic page to select ad type

        // Car Routes (Replaced individual routes with Route::resource)
        Route::resource('cars', CarController::class);

        // Boat Routes (Replaced individual routes with Route::resource)
        Route::resource('boats', BoatController::class);

        // Camper Routes
        Route::resource('campers', CamperController::class);
         

        // Commercial Vehicles Routes
        Route::resource('commercial-vehicles', CommercialVehicleController::class);
        
        // Electronics Routes
        Route::resource('electronics', ElectronicController::class);
        Route::delete('electronics/images/{electronicImage}', [ElectronicController::class, 'destroyImage'])->name('electronics.images.destroy');

        // Household Items Routes
        Route::resource('household', HouseholdItemController::class);

        // Motorcycle Routes
        Route::resource('motorcycles', MotorradAdController::class);

        // Others Routes
        Route::resource('others', OtherController::class);

        // Real Estate Routes
        Route::resource('real-estate', RealEstateController::class);

        // Services Routes
        Route::resource('services', ServiceController::class);

        // Used Vehicle Parts Routes
        Route::resource('vehicles-parts', UsedVehiclePartController::class);
    });

    // Message System
    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/start/{ad}/{receiver}/{category}', [MessageController::class, 'startAndRedirect'])->name('messages.start.redirect');
    Route::post('/messages/start', [MessageController::class, 'start'])->name('messages.start');
    Route::get('/messages/{conversation}', [MessageController::class, 'show'])->name('messages.show');
    Route::post('/messages/{conversation}', [MessageController::class, 'store'])->name('messages.store');
    Route::delete('/conversations/{id}', [MessageController::class, 'delete'])->name('conversations.delete');
});


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


  
    Route::get('categories/commercial-vehicles', [CommercialVehicleController::class, 'index'])
    ->name('categories.commercial-vehicles.index');
    


    // Campers 
    Route::get('/ads/camper/create', [CamperController::class, 'create'])->name('ads.camper.create'); 
    Route::post('/ads/camper', [CamperController::class, 'store'])->name('ads.camper.store'); 
    Route::get('/ads/camper/{camper}', [CamperController::class, 'show'])->name('ads.camper.show'); 
    Route::get('/ads/camper/{camper}/edit', [CamperController::class, 'edit'])->name('ads.camper.edit'); 
    Route::put('/ads/camper/{camper}', [CamperController::class, 'update'])->name('ads.camper.update'); 
    Route::delete('/ads/camper/{camper}', [CamperController::class, 'destroy'])->name('ads.camper.destroy'); 
Route::get('/api/camper-brands/{brandId}/models', [CamperController::class, 'getModelsByBrand'])->name('api.camper-brands.models'); 
Route::get('/ads/camper', [CamperController::class, 'index'])->name('ads.camper.index');

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
    Route::delete('/{realEstate}', [RealEstateController::class, 'destroy'])->name('destroy');


        
    }); 
}); 

require __DIR__ . '/auth.php';