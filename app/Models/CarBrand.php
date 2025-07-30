<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarBrand extends Model
{
    use HasFactory;

    // Specify the new table name
    protected $table = 'car_brands';

    protected $fillable = ['name'];

    /**
     * A car brand can have many car models.
     */
    public function carModels()
    {
        return $this->hasMany(CarModel::class, 'car_brand_id');
    }
}
