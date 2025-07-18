<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{    protected $fillable = ['brand_id', 'name', 'slug'];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
}