<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarModel extends Model
{
    protected $table = 'car_models'; // αν το όνομα δεν είναι το default (models)
    protected $fillable = ['brand_id','name', 'slug', 'brand_id'];

      public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function motorradAds()
    {
        return $this->hasMany(MotorradAd::class);
    }
}
