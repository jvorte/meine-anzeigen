<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsedVehiclePart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'part_category',
        'part_name',
        'manufacturer_part_number',
        'condition',
        'price',

        'compatible_year_from',
        'compatible_year_to',
        // ADD THESE NEW FIELDS
        'compatible_brand', 
        'compatible_model',
        'vehicle_type',
    ];

    // REMOVE these relationships as they are no longer based on foreign keys
    // public function compatibleBrand()
    // {
    //     return $this->belongsTo(Brand::class, 'compatible_brand_id');
    // }

    // public function compatibleCarModel()
    // {
    //     return $this->belongsTo(CarModel::class, 'compatible_car_model_id');
    // }

    /**
     * Get the images for the used vehicle part.
     */
    public function images()
    {
        return $this->hasMany(UsedVehiclePartImage::class);
    }

    /**
     * Get the user that owns the used vehicle part ad.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}