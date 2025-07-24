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
        'brand_id',
        'electronic_model_id',
        'year_of_purchase',
        'warranty_status',
        'accessories',
        'image_paths', // <-- Added to fillable
    ];

    protected $casts = [
        'image_paths' => 'array', // <-- Cast to array for JSON serialization/deserialization
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

        public function images()
{
    return $this->hasMany(ElectronicImage::class);
}
}
