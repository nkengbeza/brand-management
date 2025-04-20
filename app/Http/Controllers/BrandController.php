<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBrandRequest;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BrandController extends Controller
{

    public function index()
    {
        //
    }

    public function store(StoreBrandRequest $request)
    {
        $brand = Brand::create($request->validated());
        Log::info("Successfully create brand, name: " . $brand->name);
        return $brand;
    }

    public function show(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
