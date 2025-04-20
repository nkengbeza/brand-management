<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    /** @use HasFactory<\Database\Factories\BrandFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'image',
        'rating',
    ];

    public function countries()
    {
        return $this->belongsToMany(Country::class, 'country_brand', 'brand_id', 'country_id');
    }

}
