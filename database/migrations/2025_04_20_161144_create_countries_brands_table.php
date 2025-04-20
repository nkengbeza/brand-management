<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('countries_brands', function (Blueprint $table) {
            $table->id();
            $table->foreignId('country_id')
                ->nullable(false)
                ->constrained('countries', 'id', 'fk_countries_brands_countries_country_id')
                ->restrictOnDelete()
                ->restrictOnUpdate();
            $table->foreignId('brand_id')
                ->nullable(false)
                ->constrained('brands', 'id', 'fk_countries_brands_brands_brand_id')
                ->restrictOnDelete()
                ->restrictOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('countries_brands');
    }
};
