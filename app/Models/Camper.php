<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


// SoftDeletes
class Camper extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'camper_brand_id',
        'camper_model_id',
        'price',
        'first_registration',
        'show_phone',
        'show_mobile_phone',
        'show_email',
        'mileage',
        'power',
        'color',
        'condition',
        'camper_type',
        'berths',
        'total_length',
        'total_width',
        'total_height',
        'gross_vehicle_weight',
        'fuel_type',
        'transmission',
        'emission_class',
        'title',
        'description',
        'seller_name',
        'seller_phone',
        'seller_email',
        // Add any other columns from your 'campers' table that you want to be mass assignable
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [];

    /**
     * Get the images for the camper.
     */
    public function images()
    {
        return $this->hasMany(CamperImage::class);
    }

    /**
     * Get the user that owns the camper.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the brand associated with the camper.
     */
    public function camperBrand()
    {
        return $this->belongsTo(CamperBrand::class);
    }

    /**
     * Get the model associated with the camper.
     */
    public function camperModel()
    {
        return $this->belongsTo(CamperModel::class);
    }

    // You should have already removed the incorrect 'public function campers()' method from here.
    // If not, please remove it now.
}
