<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoatImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'boat_id',
        'image_path',
    ];

    /**
     * Get the boat that owns the image.
     */
    public function boat()
    {
        return $this->belongsTo(Boat::class);
    }
}
