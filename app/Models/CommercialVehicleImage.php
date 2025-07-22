<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommercialVehicleImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'commercial_vehicle_id',
        'image_path',
    ];

    /**
     * Get the commercial vehicle that owns the image.
     */
    public function commercialVehicle()
    {
        return $this->belongsTo(CommercialVehicle::class);
    }
}
