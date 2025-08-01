<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CommercialBrand extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    /**
     * Get the models for the commercial brand.
     */
    public function models(): HasMany
    {
        return $this->hasMany(CommercialModel::class, 'commercial_brand_id');
    }
}