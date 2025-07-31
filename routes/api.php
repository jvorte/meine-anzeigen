<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MotorradAdController;
use App\Http\Controllers\CarController;

Route::get('/car-brands/{id}/models', [CarController::class, 'getModels']);
// routes/api.php
Route::get('/motorcycle-brands/{id}/models', [MotorradAdController::class, 'getModels']);
