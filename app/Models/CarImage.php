<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // Added this
use Illuminate\Database\Eloquent\Model;

class CarImage extends Model
{
    use HasFactory; // Added this

    // If your migration created 'car_images' table, this line is NOT needed.
    // If your table is still named 'vehicle_images', uncomment and set it:
    // protected $table = 'vehicle_images';

    protected $fillable = [
        'car_id',
        'image_path',
        'is_thumbnail', // Ensure this column exists in your migration if you're using it
    ];

    public function car()
    {
        return $this->belongsTo(Car::class);
    }
}
