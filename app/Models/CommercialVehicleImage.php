<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // Added for type hinting

class CommercialVehicleImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'commercial_vehicle_id',
        'image_path',
        'is_thumbnail',
    ];

    /**
     * Get the commercial vehicle that owns the image.
     */
    public function commercialVehicle(): BelongsTo // Added type hinting
    {
        return $this->belongsTo(CommercialVehicle::class);
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
