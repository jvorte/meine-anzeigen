<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ElectronicModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand_id',
        'name',
        'category_hint',
    ];

    /**
     * Get the brand that owns the electronic model.
     */
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * Get the electronic items that use this model.
     */
    public function electronics()
    {
        return $this->hasMany(Electronic::class);
    }
}
