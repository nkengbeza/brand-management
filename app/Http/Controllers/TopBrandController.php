<?php

namespace App\Http\Controllers;

use App\Http\Commons\HttpResponsTrait;
use App\Http\Resources\BrandCollection;
use App\Models\Brand;
use App\Models\Country;
use Illuminate\Http\Request;

class TopBrandController extends Controller
{

    use HttpResponsTrait;

    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 15);
        $country_code = $request->header('CF-IPCountry', 'DEFAULT');
        $country_code = strtoupper($country_code);
        $country = Country::with('brands')->where('iso2', $country_code)->first();

        if ($country) {
            $brands = $country->brands()
                ->orderBy('rating', 'desc')
                ->orderBy('name', 'asc')
                ->paginate($perPage);
        } else {
            $brands = Brand::orderBy('rating', 'desc')->paginate($perPage);
        }
        $c = new BrandCollection($brands);
        $c->additional(['country' => [
            'iso2' => $country?->iso2 ?? 'DEFAULT',
            'name' => $country?->name ?? 'DEFAULT',
        ]]);
        return $c;
    }
}
