<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Household extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_slug',
        'subcategory',
        // 'brand_id',
        // 'car_model_id',
        'title',
        'description',
        'price',
        'condition',
        'images',
    ];

    protected $casts = [
        'images' => 'array', // Automatically cast the 'images' column to a PHP array
    ];

    // Define relationships if you have Brand and CarModel models
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function carModel()
    {
        return $this->belongsTo(CarModel::class);
    }
}
