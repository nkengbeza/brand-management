<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    /** @use HasFactory<\Database\Factories\CountryFactory> */
    use HasFactory;

    protected $fillable = [
        'iso2',
        'image',
    ];

    public function brands()
    {
        return $this->belongsToMany(Brand::class, 'countries_brands', 'country_id', 'brand_id');
    }

}
