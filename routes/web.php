<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\VehicleController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Απόκριση AJAX για μοντέλα (π.χ. μέσω fetch από Alpine.js)
Route::get('/models/{brandId}', function ($brandId) {
    return \App\Models\CarModel::where('brand_id', $brandId)->pluck('name', 'id');
});


// Routes με authentication
Route::middleware(['auth'])->group(function () {
    // Υποβολή αγγελίας για οχήματα
    Route::post('/vehicles', [VehicleController::class, 'store'])->name('vehicles.store');

    // Δημιουργία αγγελίας
    Route::get('/ads/create', [AdController::class, 'create'])->name('ads.create');

    // Προφίλ χρήστη
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Δημόσιες routes
Route::get('/categories/{slug}', [CategoryController::class, 'show'])->name('categories.show');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/ads/{ad}', [AdController::class, 'show'])->name('ads.show');


// Auth scaffolding routes (login, register, κλπ.)
require __DIR__ . '/auth.php';
