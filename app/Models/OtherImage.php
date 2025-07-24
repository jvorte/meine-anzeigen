<?php

// app/Models/OtherImage.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtherImage extends Model
{
    use HasFactory;
    protected $fillable = ['other_id', 'path', 'is_thumbnail'];

    public function other()
    {
        return $this->belongsTo(Other::class);
    }
}