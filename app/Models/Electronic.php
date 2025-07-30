<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // If you use SoftDeletes

class Electronic extends Model
{
    use HasFactory, SoftDeletes; // Include SoftDeletes if you have `deleted_at`

    protected $fillable = [
        'title',
        'description',
        'price',
        'user_id',
        'brand_id', // This refers to the ID in the electronic_brands table now
        'electronic_model_id',
        'condition',
        'year_of_purchase',
        'warranty_status',
        'accessories',
        'category',
        'status',
        'published_at',
        'color',
        'usage_time',
        'power',
        'operating_system',
        'storage_capacity',
        'screen_size',
        'processor',
        'ram',
    ];

    // Define relationship to the new ElectronicBrand model
    public function electronicBrand()
    {
        return $this->belongsTo(ElectronicBrand::class, 'brand_id');
    }

    // Existing relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function electronicModel()
    {
        return $this->belongsTo(ElectronicModel::class);
    }

    public function images()
    {
        return $this->hasMany(ElectronicImage::class);
    }
}