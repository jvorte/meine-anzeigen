<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsedVehiclePartImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'used_vehicle_part_id',
        'image_path',
    ];

    /**
     * Get the used vehicle part that owns the image.
     */
    public function usedVehiclePart()
    {
        return $this->belongsTo(UsedVehiclePart::class);
    }
}
