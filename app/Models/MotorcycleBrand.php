<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MotorcycleBrand extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function models()
    {
        return $this->hasMany(MotorcycleModel::class);
    }

    public function motorcycles()
    {
        return $this->hasMany(MotorradAd::class);
    }

    
}
