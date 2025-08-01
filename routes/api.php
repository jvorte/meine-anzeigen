<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MotorradAdController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\CommercialVehicleController;
use App\Http\Controllers\CamperController; 

Route::get('/camper-brands/{brandId}/models', [CamperController::class, 'getModelsByBrand'])->name('api.camper-brands.models');
Route::get('/car-brands/{id}/models', [CarController::class, 'getModels']);
Route::get('/motorcycle-brands/{id}/models', [MotorradAdController::class, 'getModels']);
Route::get('/commercial-brands/{brandId}/models', [CommercialVehicleController::class, 'getCommercialModelsByBrand']);
