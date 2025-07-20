<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Other extends Model
{
    use HasFactory;

    // Define the table if it's not the plural form of the model name
    protected $table = 'others'; // Or 'miscellaneous_ads', 'general_items'

    // Define fillable fields for mass assignment
    protected $fillable = [
        'title',
        'description',
        'price',
        'condition',
        'location', // e.g., city, region
        'images', // Store as JSON string or comma-separated if multiple
        'user_id', // If ads are linked to users
        // Add any other generic fields for 'other' items
    ];

    // Cast 'images' attribute to array if you store multiple image paths as JSON
    protected $casts = [
        'images' => 'array',
    ];

    /**
     * Get the category slug for routing.
     * This helps in generating dynamic routes like /categories/sonstiges/{id}
     */
    public function getCategorySlugAttribute()
    {
        return 'sonstiges';
    }

    // If you have a User model and ads belong to users
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
