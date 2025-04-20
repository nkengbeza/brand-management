<?php

namespace Tests\Feature;

use App\Models\Brand;
use App\Models\Country;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class TopListApiTest extends TestCase
{
    use RefreshDatabase;

    protected array $headers = [
        'Accept' => 'application/json',
    ];

    protected function setUp(): void
    {
        parent::setUp();

        $this->seedCountriesWithBrands();
    }

    protected function seedCountriesWithBrands()
    {
        $countries = [
            'CM' => 'Cameroon',
            'NG' => 'Nigeria',
            'FR' => 'France',
            'US' => 'United States',
        ];

        $brands = Brand::factory(40)->create();

        foreach ($countries as $iso2 => $name) {
            $country = Country::create(['iso2' => $iso2, 'name' => $name]);
            $brands->each(fn($brand) => $country->brands()->attach($brand));
        }
    }

    #[Test]
    public function test_returns_country_specific_toplist_with_metadata()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'CF-IPCountry' => 'CM',
        ])->getJson('/api/toplist?per_page=3');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [ // each brand
                        'id',
                        'name',
                        'image',
                        'rating',
                        'created_at',
                        'updated_at',
                    ]
                ],
                'pagination' => [
                    'page',
                    'per_page',
                    'size',
                    'total_elements',
                    'total_pages',
                ],
                'country' => [
                    'iso2',
                    'name',
                ],
            ]);

        $this->assertEquals('CM', $response->json('country.iso2'));
        $this->assertCount(3, $response->json('data'));
    }

}
