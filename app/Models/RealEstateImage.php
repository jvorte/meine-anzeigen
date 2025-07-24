<?php

// app/Models/RealEstateImage.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RealEstateImage extends Model
{
    use HasFactory;
    protected $fillable = ['real_estate_id', 'path', 'is_thumbnail'];

    public function realEstate() // Singular method name for belongsTo
    {
        return $this->belongsTo(RealEstate::class);
    }
}