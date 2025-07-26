<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // Added for type hinting

class MotorradAdImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'motorrad_ad_id',
        'image_path',
        'is_thumbnail', // Added 'is_thumbnail' to fillable for consistency
    ];

    /**
     * Get the motorrad ad that owns the image.
     */
    public function motorradAd(): BelongsTo // Added type hinting
    {
        return $this->belongsTo(MotorradAd::class);
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
