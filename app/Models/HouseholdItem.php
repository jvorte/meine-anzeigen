<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
        'image_paths', // <-- Added to fillable
    ];

    protected $casts = [
        'image_paths' => 'array', // <-- Cast to array for JSON serialization/deserialization
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
    public function images(): HasMany
{
    return $this->hasMany(HouseholdItemImage::class);
}
}
