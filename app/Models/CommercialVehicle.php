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
        'commercial_brand_id',
        'commercial_model_id',
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
    // Define the relationship to CommercialBrand
    public function commercialBrand()
    {
        return $this->belongsTo(CommercialBrand::class, 'commercial_brand_id');
    }

    // Define the relationship to CommercialModel
    public function commercialModel()
    {
        return $this->belongsTo(CommercialModel::class, 'commercial_model_id');
    }
  public function images()
{
    // Assumes an 'images' table with a 'commercial_vehicle_id' column
    // and that you have an App\Models\Image model.
    return $this->hasMany(CommercialVehicleImage::class, 'commercial_vehicle_id');
}
    // You might already have this for images

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
 
    /**
     * Get the user that owns the commercial vehicle ad.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    
}
