<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CommercialModel extends Model
{
    use HasFactory;

    protected $fillable = ['commercial_brand_id', 'name'];

    /**
     * Get the brand that owns the commercial model.
     */
    public function brand(): BelongsTo
    {
        return $this->belongsTo(CommercialBrand::class, 'commercial_brand_id');
    }
}