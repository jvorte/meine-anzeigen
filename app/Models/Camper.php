<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Camper extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'brand',
        'model',
        'price',
        'first_registration',
        'mileage',
        'power',
        'color',
        'condition',
        'camper_type',
        'berths',
        'total_length',
        'total_width',
        'total_height',
        'gross_vehicle_weight',
        'fuel_type',
        'transmission',
        'emission_class',
        'title',
        'description',
        'seller_name',
        'seller_phone',
        'seller_email',
    ];

    /**
     * Get the images for the camper.
     */
    public function images()
    {
        return $this->hasMany(CamperImage::class);
    }

    /**
     * Get the user that owns the camper.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

        public function campers()
    {
        return $this->hasMany(Camper::class);
    }

    
}