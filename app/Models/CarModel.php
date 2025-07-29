<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarModel extends Model
{
    use HasFactory;

    protected $table = 'car_models'; // Ensure this is correct

    protected $fillable = [
        'name',
        'slug',
        'car_brand_id', // Update to new foreign key name
    ];

    /**
     * A car model belongs to a car brand.
     */
    public function carBrand()
    {
        return $this->belongsTo(CarBrand::class, 'car_brand_id'); // Update to new foreign key name
    }
}
