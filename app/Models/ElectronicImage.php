<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ElectronicImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'electronic_id',
        'image_path',
        'filename', // Add filename if you store original or hashed names
        'is_thumbnail', // If you have a thumbnail concept
        'order', // If you want to order images
    ];

    /**
     * An electronic image belongs to an electronic ad.
     */
    public function electronic()
    {
        return $this->belongsTo(Electronic::class);
    }
}