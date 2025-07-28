<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Electronic extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'price',
        'user_id', // Make sure user_id is fillable if set this way
        'brand_id',
        'electronic_model_id',
        'condition',
        'warranty',
        'color',
        'usage_time',
        'power',
        'operating_system',
        'storage_capacity',
        'screen_size',
        'processor',
        'ram',
    ];

    // ... other methods ...

    /**
     * An electronic ad can have many images.
     */
    public function images()
    {
        return $this->hasMany(ElectronicImage::class);
    }

    /**
     * An electronic ad belongs to a user.
     */
    public function user()
    {
        return $this->belongsTo(User::class); // Assuming your User model is in App\Models\User
    }

    /**
     * An electronic ad belongs to a brand.
     */
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * An electronic ad belongs to an electronic model.
     */
    public function electronicModel()
    {
        return $this->belongsTo(ElectronicModel::class);
    }
}