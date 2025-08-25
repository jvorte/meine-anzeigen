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
        'brand',
        'model_name',
        'material',
        'color',
        'dimensions',
        'show_phone',
        'show_mobile_phone',
        'show_email',


    ];

    protected $casts = [];

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

       public function favoritedBy(): MorphMany
    {
        // This method defines the polymorphic relationship.
        // The first argument is the related model (Favorite).
        // The second argument is the "morph name" (the prefix for the columns).
        return $this->morphMany(Favorite::class, 'favoriteable');
    }
}
