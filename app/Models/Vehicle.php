<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
protected $fillable = [
    'category_slug', 'brand_id', 'car_model_id', 'price', 'mileage', 'registration',
    'vehicle_type', 'condition', 'warranty', 'power', 'fuel_type', 'transmission', 'drive',
    'color', 'doors', 'seats', 'seller_type', 'title', 'description', 'user_id', 'slug'
];


    public function images()
    {
        return $this->hasMany(VehicleImage::class);
    }

}
