<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Electronic extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_slug',
        'subcategory',
        'brand', // The free-text brand
        'title',
        'description',
        'price',
        'condition',
        'images',
    ];

    protected $casts = [
        'images' => 'array', // Automatically cast the 'images' column to a PHP array
    ];
}
