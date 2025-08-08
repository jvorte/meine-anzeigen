<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Electronic extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'price',
        'user_id',
        'brand', 
        'electronic_model',
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

    /**
     * Get the user that owns the electronic ad.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the images for the electronic ad.
     */
    public function images(): HasMany
    {
        return $this->hasMany(ElectronicImage::class);
    }
}