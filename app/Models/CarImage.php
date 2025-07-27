<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarImage extends Model
{
    // Define the table name if it's not 'car_images' (e.g., if it's still 'vehicle_images')
    // protected $table = 'vehicle_images'; // Uncomment and set if your table is still named 'vehicle_images'

    protected $fillable = [
        'car_id',
        'image_path',
        'is_thumbnail',
    ];

    public function car() 
    {
        return $this->belongsTo(Car::class); 
    }
}