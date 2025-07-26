<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UsedVehiclePartImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'used_vehicle_part_id', // Stellen Sie sicher, dass dies der korrekte Fremdschlüssel ist
        'image_path',
        'is_thumbnail',
    ];

    public function usedVehiclePart(): BelongsTo
    {
        return $this->belongsTo(UsedVehiclePart::class);
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
