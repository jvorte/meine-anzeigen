<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RealEstate extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_slug',
        'propertyTypeOptions',
        'title',
        'objekttyp',
        'zustand',
        'anzahl_zimmer',
        'constructionTypeOption',
        'verfugbarkeit',
        'befristung',
        'befristung_ende',
        'description',
        'objektbeschreibung',
        'lage',
        'sonstiges',
        'zusatzinformation',
        'land',
        'postcode',
        'location',
        'strasse',
        'price',
        'livingSpace',
        'grundflaeche',
        'kaution',
        'maklerprovision',
        'abloese',
        'ausstattung',
        'heating',
        'grundriss_path',
        'energieausweis_path',
        'rundgang_link',
        'objektinformationen_link',
        'zustandsbericht_link',
        'verkaufsbericht_link',
        'contact_name',
        'contact_email',
        'homepage',
         'year_of_construction',
        'pet_friendly',

    ];

    protected $casts = [
        'ausstattung' => 'array',
        'befristung_ende' => 'date:Y-m-d',
        'zusatzkontakt' => 'boolean',
        
        'year_of_construction' => 'integer',
    ];

    public function images()
    {
        return $this->hasMany(RealEstateImage::class);
    }

        public function user()
{
    return $this->belongsTo(User::class);
}
}
