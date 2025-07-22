<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommercialVehicle extends Model
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
        'commercial_vehicle_type',
        'fuel_type',
        'transmission',
        'payload_capacity',
        'gross_vehicle_weight',
        'number_of_axles',
        'emission_class',
        'seats',
    ];

    /**
     * Get the brand associated with the commercial vehicle.
     */
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * Get the car model associated with the commercial vehicle.
     */
    public function carModel()
    {
        return $this->belongsTo(CarModel::class);
    }

    /**
     * Get the images for the commercial vehicle.
     */
    public function images()
    {
        return $this->hasMany(CommercialVehicleImage::class);
    }

    /**
     * Get the user that owns the commercial vehicle ad.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
