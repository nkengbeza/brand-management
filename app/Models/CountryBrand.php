<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CountryBrand extends Model
{
    /** @use HasFactory<\Database\Factories\CountryBrandFactory> */
    use HasFactory;

    protected $table = 'countries_brands';
}
