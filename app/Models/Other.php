<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Other extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_slug',
        'title',
        'description',
        'price',
        'condition',
        'location',
        'contact_phone',
        'images', // <-- Added to fillable
    ];

    protected $casts = [
        'images' => 'array', // <-- Cast to array for JSON serialization/deserialization
    ];

    /**
     * Get the user that owns the other ad.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
