<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ElectronicBrand extends Model
{
    use HasFactory;

    // Specify the table name since it's not the plural of the model name
    protected $table = 'electronic_brands';

    // Define which attributes are mass assignable
    protected $fillable = ['name'];

    // If you plan to have ElectronicModels tied to these brands
    public function electronicModels()
    {
        return $this->hasMany(ElectronicModel::class);
    }

    // An electronic brand has many electronic listings
    public function electronics()
    {
        return $this->hasMany(Electronic::class, 'brand_id'); // Specify foreign key if it's not electronic_brand_id
    }
}