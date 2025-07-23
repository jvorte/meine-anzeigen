<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory; // Add this if you use factories for CarModel

class CarModel extends Model
{
    use HasFactory; // It's good practice to include this if you use factories

    protected $table = 'car_models';
    protected $fillable = ['brand_id', 'name', 'slug']; // Corrected: Removed duplicate 'brand_id'

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function motorradAds()
    {
        return $this->hasMany(MotorradAd::class);
    }
}