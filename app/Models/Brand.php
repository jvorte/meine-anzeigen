<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{

    
    
    protected $fillable = ['name'];
    public function models()
    {
        return $this->hasMany(ModelCar::class);
    }

    public function motorradAds()
    {
        return $this->hasMany(MotorradAd::class);
    }

    public function carModels()
    {
        return $this->hasMany(CarModel::class);
    }
}
