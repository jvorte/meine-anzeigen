<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Boat extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'brand',        // string, όχι foreign key
        'model',
        'year_of_construction',
        'condition',
        'price',
        'boat_type',
        'material',
        'total_length',
        'total_width',
        'berths',
        'engine_type',
        'engine_power',
        'operating_hours',
        'last_service',
        'country',
        'zip_code',
        'city',
        'street',
        'seller_name',
        'seller_phone',
        'seller_email',
    ];

    /**
     * Get the brand associated with the boat.
     */
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }


    public function boatModel()
    {
        return $this->belongsTo(Boat::class, 'boat_model_id');
    }
    /**
     * Get the car model (used as boat model) associated with the boat.
     */
    public function carModel()
    {
        return $this->belongsTo(CarModel::class);
    }

    /**
     * Get the images for the boat.
     */
    public function images()
    {
        return $this->hasMany(BoatImage::class);
    }

    /**
     * Get the user that owns the boat ad.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
