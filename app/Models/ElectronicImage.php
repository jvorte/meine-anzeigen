<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ElectronicImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'electronic_id',
        'image_path',   // <--- Korrigiert von 'path' zu 'image_path' (falls es 'path' war)
        'is_thumbnail', // <--- Korrigiert von 'is_main' zu 'is_thumbnail'
        // 'description', // <--- Entfernt, da nicht in der Schema-Liste
    ];

    /**
     * Get the electronic item that owns the image.
     */
    public function electronic(): BelongsTo
    {
        return $this->belongsTo(Electronic::class);
    }

    /**
     * Get the image path. This accessor allows you to use $image->path in Blade.
     * It returns the value of the 'image_path' attribute.
     */
    public function getPathAttribute()
    {
        return $this->attributes['image_path'];
    }
}
