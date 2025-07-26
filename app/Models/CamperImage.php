<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // Added for type hinting

class CamperImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'camper_id',
        'image_path',
        'is_thumbnail', // Added 'is_thumbnail' to fillable for consistency
    ];

    /**
     * Get the camper that owns the image.
     */
    public function camper(): BelongsTo // Added type hinting
    {
        return $this->belongsTo(Camper::class);
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
