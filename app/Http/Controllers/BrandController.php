<?php

namespace App\Http\Controllers;

use App\Http\Commons\HttpResponsTrait;
use App\Http\Requests\StoreBrandRequest;
use App\Http\Resources\BrandCollection;
use App\Http\Resources\BrandResource;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BrandController extends Controller
{

    use HttpResponsTrait;

    public function index()
    {
        $perPage = request('per_page', 15);

        return new BrandCollection(Brand::paginate($perPage));
    }

    public function store(StoreBrandRequest $request)
    {
        $brand = Brand::create($request->validated());
        Log::info("Successfully create brand, name: " . $brand->name);
        return $brand;
    }

    public function show(int $id)
    {
        $brand = Brand::find($id);
        if (is_null($brand)) {
            $this->notFoundResponse('brand', $id);
        }
        return new BrandResource($brand);
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
