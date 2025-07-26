<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_slug',
        'dienstleistung_kategorie',
        'title',
        'description',
        'region',
        'price',
        'verfugbarkeit',
        'contact_name',
        'contact_tel',
        'contact_email',
    
    ];

    protected $casts = [
  
    ];

    public function images()
    {
        return $this->hasMany(ServiceImage::class);
    }
}
