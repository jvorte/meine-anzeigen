<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $fillable = [
        'category_slug', 'brand_id', 'car_model_id', 'price', 'mileage', 'registration',
        'vehicle_type', 'condition', 'warranty', 'power', 'fuel_type', 'transmission', 'drive',
        'color', 'doors', 'seats', 'seller_type', 'title', 'description', 'user_id', 'slug'
    ];

    public function images()
    {
        // Change VehicleImage::class to CarImage::class
        return $this->hasMany(CarImage::class);
    }

    // You might also want to add relationships for Brand and CarModel for convenience
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function carModel()
    {
        return $this->belongsTo(CarModel::class, 'car_model_id'); // Specify foreign key if it's not 'car_model_id' by default
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}