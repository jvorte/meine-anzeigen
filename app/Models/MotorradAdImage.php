<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MotorradAdImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'motorrad_ad_id',
        'image_path',
    ];

    /**
     * Get the motorrad ad that owns the image.
     */
    public function motorradAd()
    {
        return $this->belongsTo(MotorradAd::class);
    }
}