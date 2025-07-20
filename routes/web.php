<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
// Import all specific ad type controllers
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\PartController;
use App\Http\Controllers\ElectronicsController; // Corrected from ElectronicsController
use App\Http\Controllers\HouseholdController;
use App\Http\Controllers\RealEstateController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\BoatController;
use App\Http\Controllers\OtherController;


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
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard'); // Redundant, but kept for clarity if used elsewhere

// Routes with authentication
Route::middleware(['auth'])->group(function () {
    // Ad submission routes for specific categories
    Route::post('/vehicles', [VehicleController::class, 'store'])->name('vehicles.store');
    Route::post('/parts', [PartController::class, 'store'])->name('parts.store');
    Route::post('/electronics', [ElectronicsController::class, 'store'])->name('electronics.store'); // Corrected controller name
    Route::post('/household', [HouseholdController::class, 'store'])->name('household.store');
    Route::post('/realestate', [RealEstateController::class, 'store'])->name('realestate.store');
    Route::post('/services', [ServiceController::class, 'store'])->name('services.store');
    Route::post('/boote', [BoatController::class, 'store'])->name('boote.store'); // Added store route for boats
    Route::post('/sonstiges', [OtherController::class, 'store'])->name('sonstiges.store'); // Added store route for others

    // Ad creation form route
    Route::get('/ads/create', [AdController::class, 'create'])->name('ads.create');

    // User profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Public routes
// Generic category show route - This handles /categories/{slug} for all categories
Route::get('/categories/{slug}', [CategoryController::class, 'show'])->name('categories.show');

// Specific ad detail pages for each model type
// These are crucial for the "Details ansehen" links in categories/show.blade.php
Route::prefix('categories')->name('categories.')->group(function () {
    // Example: /categories/fahrzeuge/{vehicle}
    Route::get('/fahrzeuge/{vehicle}', [VehicleController::class, 'show'])->name('fahrzeuge.show');
    // Example: /categories/boote/{boat}
    Route::get('/boote/{boat}', [BoatController::class, 'show'])->name('boote.show');
    // Example: /categories/fahrzeugeteile/{part}
    Route::get('/fahrzeugeteile/{part}', [PartController::class, 'show'])->name('fahrzeugeteile.show');
    // Example: /categories/elektronik/{electronic}
    Route::get('/elektronik/{electronic}', [ElectronicsController::class, 'show'])->name('elektronik.show'); // Corrected controller name
    // Example: /categories/haushalt/{household}
    Route::get('/haushalt/{household}', [HouseholdController::class, 'show'])->name('haushalt.show');
    // Example: /categories/immobilien/{realEstate}
    Route::get('/immobilien/{realEstate}', [RealEstateController::class, 'show'])->name('immobilien.show');
    // Example: /categories/dienstleistungen/{service}
    Route::get('/dienstleistungen/{service}', [ServiceController::class, 'show'])->name('dienstleistungen.show');
    // Example: /categories/sonstiges/{other}
    Route::get('/sonstiges/{other}', [OtherController::class, 'show'])->name('sonstiges.show');
});

// Fallback for generic ad show (if ads are not strictly categorized by URL)
// This might be redundant if all ads are accessed via their category-specific routes
Route::get('/ads/{ad}', [AdController::class, 'show'])->name('ads.show');


// Auth scaffolding routes (login, register, etc.)
require __DIR__ . '/auth.php';

