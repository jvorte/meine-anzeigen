<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\VehicleController;


// routes/web.php ή routes/api.php (αν είναι μέσω fetch API)
Route::get('/models/{brandId}', function ($brandId) {
    return \App\Models\CarModel::where('brand_id', $brandId)->pluck('name', 'id');
});

Route::post('/vehicles', [VehicleController::class, 'store'])->name('vehicles.store');


Route::get('/categories/{slug}', [CategoryController::class, 'show'])->name('categories.show');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('/ads/create', [AdController::class, 'create'])->name('ads.create');
    Route::post('/ads', [AdController::class, 'store'])->name('ads.store');
});

Route::get('/ads/{ad}', [AdController::class, 'show'])->name('ads.show');


// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
