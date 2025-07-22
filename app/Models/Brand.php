<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    /**
     * Get the car models for the brand.
     */
    public function carModels()
    {
        return $this->hasMany(CarModel::class);
    }

    /**
     * Get the motorrad ads for the brand.
     */
    public function motorradAds()
    {
        return $this->hasMany(MotorradAd::class);
    }

    /**
     * Get the commercial vehicles for the brand.
     */
    public function commercialVehicles()
    {
        return $this->hasMany(CommercialVehicle::class);
    }

    /**
     * Get the campers for the brand.
     */
    public function campers()
    {
        return $this->hasMany(Camper::class);
    }

    /**
     * Get the used vehicle parts for the brand (compatible brand).
     */
    public function usedVehicleParts()
    {
        return $this->hasMany(UsedVehiclePart::class, 'compatible_brand_id');
    }

    /**
     * Get the boats for the brand.
     */
    public function boats()
    {
        return $this->hasMany(Boat::class);
    }

    /**
     * Get the electronic models for the brand.
     * This is the crucial relationship needed by ElectronicModelSeeder.
     */
    public function electronicModels()
    {
        return $this->hasMany(ElectronicModel::class);
    }

    /**
     * Get the electronics for the brand.
     */
    public function electronics()
    {
        return $this->hasMany(Electronic::class);
    }
}
