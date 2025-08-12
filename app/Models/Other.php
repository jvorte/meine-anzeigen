<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Other extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'price',
        'condition',
        'description',
        'category_slug',
        'show_phone',
        'show_mobile_phone',
        'show_email',
    ];

    protected $casts = [];

    /**
     * Get the user that owns the other ad.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function images()
    {
        return $this->hasMany(OtherImage::class);
    }
}
