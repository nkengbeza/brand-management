<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Country;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $cm = Country::create(['iso2' => 'CM', 'name' => 'Cameroon']);
        $ng = Country::create(['iso2' => 'NG', 'name' => 'Nigeria']);
        $fr = Country::create(['iso2' => 'FR', 'name' => 'France']);
        $us = Country::create(['iso2' => 'US', 'name' => 'United States']);

        $brands = Brand::factory(40)->create();

        $brands->each(fn($brand) => $cm->brands()->attach($brand));
        $brands->each(fn($brand) => $ng->brands()->attach($brand));
        $brands->each(fn($brand) => $fr->brands()->attach($brand));
        $brands->each(fn($brand) => $us->brands()->attach($brand));
    }
}
