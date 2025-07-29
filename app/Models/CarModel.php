<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarModel extends Model
{
    use HasFactory;

    protected $table = 'car_models'; // This is correct

    protected $fillable = [
        'name',
        'slug',
        'car_brand_id', // This is correct
    ];

    /**
     * A car model belongs to a car brand.
     */
    public function carBrand()
    {
        return $this->belongsTo(CarBrand::class, 'car_brand_id'); // This is correct
    }
}
