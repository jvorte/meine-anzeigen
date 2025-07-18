<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelCar extends Model
{

    
        protected $table = 'car_models';
    protected $fillable = ['name', 'brand_id'];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
}
