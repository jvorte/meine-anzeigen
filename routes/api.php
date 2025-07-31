<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CarController;

Route::get('/car-brands/{id}/models', [CarController::class, 'getModels']);
