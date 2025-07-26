<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany; // Behalten Sie dies bei, wenn Sie es verwenden

class HouseholdItem extends Model
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
        'model_name',
        'material',
        'color',
        'dimensions',
      
    ];

    protected $casts = [

    ];

    /**
     * Get the brand associated with the household item.
     */
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * Get the user that owns the household item ad.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the images for the household item.
     */
    public function images(): HasMany
    {
        return $this->hasMany(HouseholdItemImage::class);
    }
}
