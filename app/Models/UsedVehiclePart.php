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
        'compatible_brand_id',
        'compatible_car_model_id',
        'compatible_year_from',
        'compatible_year_to',
    ];

    /**
     * Get the brand this part is compatible with.
     */
    public function compatibleBrand()
    {
        return $this->belongsTo(Brand::class, 'compatible_brand_id');
    }

    /**
     * Get the car model this part is compatible with.
     */
    public function compatibleCarModel()
    {
        return $this->belongsTo(CarModel::class, 'compatible_car_model_id');
    }

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
