<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ElectronicImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'electronic_id',
        'image_path',
        'is_main',
        'description',
    ];

    // Σχέση: Η εικόνα ανήκει σε ένα Electronic
    public function electronic(): BelongsTo
    {
        return $this->belongsTo(Electronic::class); // Ή το όνομα του Model του κύριου πίνακα σου
    }
}