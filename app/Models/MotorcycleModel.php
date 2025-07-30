<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MotorcycleModel extends Model
{
    use HasFactory;

    protected $fillable = ['motorcycle_brand_id', 'name'];

    public function brand()
    {
        return $this->belongsTo(MotorcycleBrand::class, 'motorcycle_brand_id');
    }

    public function motorcycles()
    {
        return $this->hasMany(MotorradAd::class);
    }
}
