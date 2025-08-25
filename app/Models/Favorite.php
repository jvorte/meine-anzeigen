<?php

// app/Models/Favorite.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Favorite extends Model
{
    // The table name is 'favorites' by default based on the model name
    protected $table = 'favorites';
    
    // We do not need to set $timestamps to true, as it is true by default.
    // If you had it set to false, you would need to set it to true here.
    // protected $timestamps = true; 

    // Define the inverse polymorphic relationship
    public function favoriteable(): MorphTo
    {
        return $this->morphTo();
    }
}