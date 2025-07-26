<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RealEstateImage extends Model
{
    use HasFactory;
    protected $fillable = ['real_estate_id', 'image_path', 'is_thumbnail']; // 'image_path' ist hier korrekt

    public function realEstate() // Singularer Methodenname für belongsTo
    {
        return $this->belongsTo(RealEstate::class);
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
