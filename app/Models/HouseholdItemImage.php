<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HouseholdItemImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'household_item_id',
        'image_path',  
        'is_thumbnail',
    ];

    /**
     * Get the household item that owns the image.
     */
    public function householdItem(): BelongsTo
    {
        return $this->belongsTo(HouseholdItem::class);
    }

    /**
     * Holt den Bildpfad. Dieser Accessor ermöglicht die Verwendung von $image->path in Blade.
     * Er gibt den Wert des 'image_path'-Attributs zurück.
     */
    public function getPathAttribute()
    {
        return $this->attributes['image_path'];
    }
}
