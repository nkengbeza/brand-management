<?php

use App\Http\Controllers\HomeController;
use App\Http\Middleware\SetWebLocale;
use Illuminate\Support\Facades\Route;


Route::middleware([SetWebLocale::class])->group(function () {

    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::get('/language/{locale}', function ($locale) {
        if (in_array($locale, ['en', 'fr'])) {
            session()->put('locale', $locale);
        }
        return redirect()->back();
    })->name('language.switch');

});
