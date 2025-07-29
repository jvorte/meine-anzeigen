<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // Assuming you might want soft deletes for ads

class MotorradAd extends Model
{
    use HasFactory; // Removed SoftDeletes here as it wasn't in your provided MotorradAd model, but added it back if you need it.

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'motorcycle_brand_id', // Changed from 'brand_id'
        'motorcycle_model_id', // Changed from 'car_model_id'
        'first_registration',
        'mileage',
        'power',
        'color',
        'condition',
    ];

    /**
     * Get the motorcycle brand associated with the motorrad ad.
     */
    public function motorcycleBrand() // Changed relationship name
    {
        return $this->belongsTo(MotorcycleBrand::class);
    }

    /**
     * Get the motorcycle model associated with the motorrad ad.
     */
    public function motorcycleModel() // Changed relationship name
    {
        return $this->belongsTo(MotorcycleModel::class);
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
