<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\TopBrandController;
use Illuminate\Support\Facades\Route;

Route::apiResource('brands', BrandController::class);
Route::get('toplist', [TopBrandController::class, 'index']);
