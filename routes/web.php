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

// Main Dashboard/Home Page
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard', [DashboardController::class, 'index']); // Added redirect for /dashboard to home

// Ad Search
Route::get('/ads/search', [AdController::class, 'search'])->name('ads.search');

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
    Route::get('/commercial-vehicle', [CommercialVehicleController::class, 'index'])->name('commercial-vehicle.index');
    Route::get('/campers', [CamperController::class, 'index'])->name('campers.index');
});

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
    Route::get('/commercial-vehicle/{commercialVehicle}', [CommercialVehicleController::class, 'show'])->name('commercial-vehicle.show');
    Route::get('/campers/{camper}', [CamperController::class, 'show'])->name('campers.show');
});

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
        Route::resource('commercial-vehicle', CommercialVehicleController::class);
        
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

// Auth scaffolding routes (login, register, etc.) - ALWAYS keep this at the very end
require __DIR__ . '/auth.php';