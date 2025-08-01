<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CamperModel extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'camper_brand_id',
        'name',
        'slug',
        'year_from', // Add these if you include year range in your migration
        'year_to',   // Add these if you include year range in your migration
    ];

    /**
     * Get the brand that owns the camper model.
     */
    public function camperBrand()
    {
        return $this->belongsTo(CamperBrand::class);
    }
}