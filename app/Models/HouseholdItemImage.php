<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // Πρόσθεσε αυτή τη γραμμή

class HouseholdItemImage extends Model
{
    use HasFactory;

    // Ορίζουμε το όνομα του πίνακα αν δεν ακολουθεί τους κανόνες του Laravel (πληθυντικός του μοντέλου)
    // Αν ο πίνακάς σου λέγεται 'household_item_images', δεν χρειάζεται αυτή η γραμμή.
    // protected $table = 'household_item_images';

    // Ορίζουμε ποιες στήλες μπορούν να γεμιστούν μαζικά
    protected $fillable = [
        'household_item_id',
        'path',          // Στην βάση σου λέγεται 'path', όχι 'image_path'
        'is_thumbnail',
    ];

    /**
     * Get the household item that owns the image.
     */
    public function householdItem(): BelongsTo
    {
        return $this->belongsTo(HouseholdItem::class);
    }
}