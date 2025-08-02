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
        'service_type',
        'title',
        'description',
        'location',
        'price',
        'availability',
    ];


    protected $casts = [
  
    ];

    public function images()
    {
        return $this->hasMany(ServiceImage::class);
    }

    public function user()
{
    return $this->belongsTo(User::class);
}

}
