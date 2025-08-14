<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\MyAdsController;
use App\Http\Controllers\AdController;
use App\Http\Controllers\NewsletterController;

// Import all dedicated ad controllers
use App\Http\Controllers\BoatController;
use App\Http\Controllers\CamperController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\CommercialVehicleController;
use App\Http\Controllers\ElectronicController;
use App\Http\Controllers\HouseholdItemController;
use App\Http\Controllers\MotorradAdController;
use App\Http\Controllers\OtherController;
use App\Http\Controllers\RealEstateController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\UsedVehiclePartController;
use Illuminate\Support\Facades\Session;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/lang/{locale}', function (string $locale) {
    if (! in_array($locale, ['en', 'de'])) {
        abort(400); // Invalid locale provided
    }

    // Put the selected locale in the session
    Session::put('locale', $locale);

    return redirect()->back();
})->name('lang.switch');

// --- PUBLIC ROUTES ---

Route::delete('/conversations/{conversation}', [MessageController::class, 'delete'])
    ->name('conversations.delete');
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard', fn () => redirect()->route('dashboard'));

Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');

Route::view('/contact', 'contact')->name('contact');
Route::view('/data-protection', 'legal.data-protection')->name('legal.data-protection');
Route::view('/terms-conditions', 'legal.terms-conditions')->name('legal.terms-conditions');

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
    Route::get('/commercial-vehicles', [CommercialVehicleController::class, 'index'])->name('commercial-vehicles.index');
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
    Route::get('/commercial-vehicle/{commercialVehicle}', [CommercialVehicleController::class, 'show'])->name('commercial-vehicles.show');
    Route::get('/campers/{camper}', [CamperController::class, 'show'])->name('campers.show');
});

// --- API/AJAX ROUTES ---
Route::prefix('api')->name('api.')->group(function () {
    Route::get('/car-brands/{brandId}/models', [CarController::class, 'getModelsByBrand'])->name('car-brands.models');
    Route::get('/camper-brands/{brandId}/models', [CamperController::class, 'getModelsByBrand'])->name('camper-brands.models');
    Route::get('/motorcycle-models/{brandId}', [MotorradAdController::class, 'getModelsByBrand'])->name('motorcycle-models');
    Route::get('/electronic-models/{brandId}', function ($brandId) {
        return App\Models\ElectronicModel::where('brand_id', $brandId)->orderBy('name')->pluck('name', 'id');
    })->name('electronic-models');
});

// --- AUTHENTICATED ROUTES ---
Route::middleware(['auth'])->group(function () {
       Route::get('/ads', [AdController::class, 'index'])->name('ads.index');
    // User Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::delete('/profile/photo', [ProfileController::class, 'destroyProfilePhoto'])->name('profile.destroy-profile-photo');

    // My Ads
    Route::get('/meine-anzeigen', [MyAdsController::class, 'index'])->name('my-ads.index');

    // Ad Creation & Management
    Route::prefix('ads')->name('ads.')->group(function () {
        // Generic page to select ad type
        Route::get('/create', [AdController::class, 'create'])->name('create');

        // Ad Resource Routes (consolidated)
        Route::resource('cars', CarController::class);
        Route::resource('boats', BoatController::class);
        Route::resource('campers', CamperController::class);
        Route::resource('commercial-vehicles', CommercialVehicleController::class);
        Route::resource('electronics', ElectronicController::class);
        Route::resource('household', HouseholdItemController::class)->except(['show']); // show is handled by public categories group
        Route::resource('motorcycles', MotorradAdController::class);
        Route::resource('others', OtherController::class);
        Route::resource('real-estate', RealEstateController::class);
        Route::resource('services', ServiceController::class);
        Route::resource('vehicles-parts', UsedVehiclePartController::class);

        // Custom Routes that don't fit into resource controllers
        Route::delete('electronics/images/{electronicImage}', [ElectronicController::class, 'destroyImage'])->name('electronics.images.destroy');
    });

    // Message System
    Route::prefix('messages')->name('messages.')->group(function () {
        Route::get('/', [MessageController::class, 'index'])->name('index');
        Route::get('/start/{ad}/{receiver}/{category}', [MessageController::class, 'startAndRedirect'])->name('start.redirect');
        Route::post('/start', [MessageController::class, 'start'])->name('start');
        Route::get('/{conversation}', [MessageController::class, 'show'])->name('show');
        Route::post('/{conversation}', [MessageController::class, 'store'])->name('store');
        Route::delete('/{conversation}', [MessageController::class, 'delete'])->name('delete');
    });
});

require __DIR__ . '/auth.php';