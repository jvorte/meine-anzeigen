<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtherImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'other_id', // Stellen Sie sicher, dass dies der korrekte Fremdschlüssel ist
        'image_path', // <--- HIER AUF 'image_path' GEÄNDERT
        'is_thumbnail', // Fügen Sie dies hinzu, falls es noch nicht da ist
    ];

    public function other()
    {
        return $this->belongsTo(Other::class);
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
