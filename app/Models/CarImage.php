<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarImage extends Model
{
    // Define the table name if it's not 'car_images' (e.g., if it's still 'vehicle_images')
    // protected $table = 'vehicle_images'; // Uncomment and set if your table is still named 'vehicle_images'

    protected $fillable = [
        'car_id', // <--- CHANGED: from 'vehicle_id' to 'car_id'
        'image_path',
    ];

    public function car() // <--- CHANGED: method name from 'vehicle' to 'car'
    {
        return $this->belongsTo(Car::class); // <--- CHANGED: from Vehicle::class to Car::class
    }
}