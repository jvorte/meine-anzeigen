<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarModel extends Model
{
    protected $table = 'car_models'; // αν το όνομα δεν είναι το default (models)
    protected $fillable = ['name', 'slug', 'brand_id'];
}
