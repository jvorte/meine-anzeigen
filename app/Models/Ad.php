<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    protected $fillable = [
        'title', 'description_de', 'description_en', 'user_id', 'category_id'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
