<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Ad extends Model
{



    public function category()
    {
        return $this->belongsTo(Category::class);
    }

   public function favoritedBy(): MorphMany
    {
        return $this->morphMany(Favorite::class, 'favoriteable');
    }


}
