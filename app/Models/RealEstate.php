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
        'immobilientyp',
        'title',
        'objekttyp',
        'zustand',
        'anzahl_zimmer',
        'bautyp',
        'verfugbarkeit',
        'befristung',
        'befristung_ende',
        'description',
        'objektbeschreibung',
        'lage',
        'sonstiges',
        'zusatzinformation',
        'land',
        'plz',
        'ort',
        'strasse',
        'gesamtmiete',
        'wohnflaeche',
        'grundflaeche',
        'kaution',
        'maklerprovision',
        'abloese',
        'ausstattung',
        'heizung',
        'images',
        'grundriss_path',
        'energieausweis_path',
        'rundgang_link',
        'objektinformationen_link',
        'zustandsbericht_link',
        'verkaufsbericht_link',
        'contact_name',
        'contact_tel',
        'contact_email',
        'firmenname',
        'homepage',
        'telefon2',
        'fax',
        'immocard_id',
        'immocard_firma_id',
        'zusatzkontakt',
    ];

    protected $casts = [
        'ausstattung' => 'array',
        'images' => 'array',
        'befristung_ende' => 'date', // Cast date field
        'zusatzkontakt' => 'boolean', // Cast boolean field
    ];

    public function images()
{
    return $this->hasMany(RealEstateImage::class);
}
}