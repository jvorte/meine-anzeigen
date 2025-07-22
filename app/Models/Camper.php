<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Camper extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'brand_id',
        'car_model_id',
        'first_registration',
        'mileage',
        'power',
        'color',
        'condition',
        'price',
        'camper_type',
        'berths',
        'total_length',
        'total_width',
        'total_height',
        'gross_vehicle_weight',
        'fuel_type',
        'transmission',
        'emission_class',
    ];

    /**
     * Get the brand associated with the camper.
     */
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * Get the car model associated with the camper.
     */
    public function carModel()
    {
        return $this->belongsTo(CarModel::class);
    }

    /**
     * Get the images for the camper.
     */
    public function images()
    {
        return $this->hasMany(CamperImage::class);
    }

    /**
     * Get the user that owns the camper ad.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
