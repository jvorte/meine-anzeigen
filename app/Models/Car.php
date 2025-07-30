<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // Added this
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory; // Added this

 protected $fillable = [
        'category_slug',
        'brand_id', 
        'car_model_id',
        'price',
        'mileage',
        'registration',
        'vehicle_type',
        'condition',
        'warranty',
        'power',
        'fuel_type',
        'transmission',
        'drive',
        'color',
        'doors',
        'seats',
        'seller_type',
        'title',
        'description',
        'user_id',
        'slug'
    ];


    public function images()
    {
        return $this->hasMany(CarImage::class); // Already correct here
    }

    // Corrected relationship for CarBrand
    public function carBrand() // FIX: Renamed function from 'brand' to 'carBrand' for clarity and consistency
    {
        return $this->belongsTo(CarBrand::class, 'brand_id'); // FIX: Pointed to CarBrand::class and specified foreign key
    }

    public function carModel()
    {
        return $this->belongsTo(CarModel::class, 'car_model_id'); // Correct, explicit foreign key is good
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
