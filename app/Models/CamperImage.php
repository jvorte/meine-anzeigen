<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CamperImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'camper_id',
        'image_path',
         'is_thumbnail',
    ];

    /**
     * Get the camper that owns the image.
     */
    public function camper()
    {
        return $this->belongsTo(Camper::class);
    }
}