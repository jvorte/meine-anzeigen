<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MotorradAd extends Model
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
    ];

    /**
     * Get the brand associated with the motorrad ad.
     */
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * Get the car model associated with the motorrad ad.
     */
    public function carModel()
    {
        return $this->belongsTo(CarModel::class);
    }

    /**
     * Get the images for the motorrad ad.
     */
    public function images()
    {
        return $this->hasMany(MotorradAdImage::class);
    }

    /**
     * Get the user that owns the motorrad ad.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}