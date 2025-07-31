<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

   protected $fillable = [
        'user_id', 
        'category_slug',
        'dienstleistung_kategorie',
        'title',
        'description',
        'region',
        'price',
        'verfugbarkeit',
    ];


    protected $casts = [
  
    ];

    public function images()
    {
        return $this->hasMany(ServiceImage::class);
    }
}
