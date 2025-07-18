<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $fillable = [
    'user_id',
    'brand_id',
    'car_model_id',
    'title',
    'description',
    'price',
    'mileage',
    'fuel_type',
    'transmission',
    'location',
];

}
