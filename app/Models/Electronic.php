<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Electronic extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'price',
        'condition',
        'category',
        'brand',
        'model',
        'electronic_model_id',
        'year_of_purchase',
        'warranty_status',
        'accessories',
     
    ];

    protected $casts = [
        
    ];

    /**
     * Get the brand associated with the electronic item.
     */
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * Get the electronic model associated with the electronic item.
     */
    public function electronicModel()
    {
        return $this->belongsTo(ElectronicModel::class);
    }

    /**
     * Get the user that owns the electronic ad.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the images for the electronic ad.
     */
    public function images()
    {
        return $this->hasMany(ElectronicImage::class);
    }
}
