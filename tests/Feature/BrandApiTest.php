<?php

namespace Tests\Feature;

use App\Models\Brand;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class BrandApiTest extends TestCase
{

    use RefreshDatabase;

    protected array $headers = [
        'Accept' => 'application/json',
        'Accept-Language' => 'en'
    ];

    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate');
    }

    #[Test]
    public function creates_a_brand_successfully()
    {
        $payload = [
            'name' => 'Nike',
            'image' => 'https://example.com/nike.png',
            'rating' => 5,
        ];

        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Accept-Language' => 'fr',
        ])->postJson('/api/brands', $payload);

        $response->assertStatus(201)
            ->assertJsonFragment([
                'name' => 'Nike',
                'rating' => 5,
            ]);

        $this->assertDatabaseHas('brands', [
            'name' => 'Nike',
        ]);
    }

    #[Test]
    public function returns_validation_messages_in_french()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Accept-Language' => 'fr'
        ])->postJson('/api/brands', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'image', 'rating']);

        $this->assertStringContainsString(
            'Le champ',
            $response->json('errors')['name'][0]
        );
    }

    #[Test]
    public function returns_validation_messages_in_english()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Accept-Language' => 'en'
        ])->postJson('/api/brands', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'image', 'rating']);

        $this->assertStringContainsString(
            'The',
            $response->json('errors')['name'][0]
        );
    }

    #[Test]
    public function returns_paginated_list_of_brands()
    {
        Brand::factory()->count(30)->create();

        $response = $this->withHeaders($this->headers)->getJson('/api/brands');

        $response->assertStatus(200)
            ->assertJson(function (AssertableJson $json) {
                $json->has('data', 15)
                    ->has('pagination', function ($json) {
                        $json->where('page', 1)
                            ->where('per_page', 15)
                            ->where('size', 15)
                            ->where('total_elements', 30)
                            ->where('total_pages', 2);
                    });
            });
    }

    #[Test]
    public function returns_a_single_brand_by_id()
    {
        $brand = Brand::factory()->create([
            'name' => 'Nike',
            'image' => 'https://example.com/nike.png',
            'rating' => 5,
        ]);

        $response = $this->withHeaders($this->headers)->getJson("/api/brands/{$brand->id}");

        $response->assertStatus(200)
            ->assertJson(function (AssertableJson $json) use ($brand) {
                $json->has('data')
                    ->where('data.id', $brand->id)
                    ->where('data.name', $brand->name)
                    ->where('data.image', $brand->image)
                    ->where('data.rating', $brand->rating);
            });
    }

    #[Test]
    public function returns_not_found_when_does_not_exist()
    {
        $response = $this->withHeaders($this->headers)->getJson('/api/brands/999999');

        $response->assertStatus(404)
            ->assertJson([
                'status' => 'not_found',
                'message' => 'The resource brand with identifier 999999 does not exist.',
            ]);
    }

    #[Test]
    public function updates_a_brand_successfully()
    {
        $brand = Brand::factory()->create([
            'name' => 'Old Brand',
            'image' => 'https://example.com/old.png',
            'rating' => 2,
        ]);

        $payload = [
            'name' => 'Updated Brand',
            'image' => 'https://example.com/updated.png',
            'rating' => 5,
        ];

        $response = $this->withHeaders($this->headers)
            ->putJson("/api/brands/{$brand->id}", $payload);

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'name' => 'Updated Brand',
                    'image' => 'https://example.com/updated.png',
                    'rating' => 5,
                ]
            ]);

        $this->assertDatabaseHas('brands', [
            'id' => $brand->id,
            'name' => 'Updated Brand',
        ]);
    }

    #[Test]
    public function returns_validation_errors_if_data_is_invalid()
    {
        $brand = Brand::factory()->create();

        $payload = [
            'name' => '',
            'image' => 'not-a-url',
            'rating' => 10,
        ];

        $response = $this->withHeaders($this->headers)
            ->putJson("/api/brands/{$brand->id}", $payload);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'image', 'rating']);
    }

    #[Test]
    public function returns_not_found_if_update_brand_does_not_exist()
    {
        $response = $this->withHeaders($this->headers)
            ->putJson('/api/brands/999999', [
                'name' => 'Anything',
                'image' => 'https://example.com/brand.png',
                'rating' => 4,
            ]);

        $response->assertStatus(404)
            ->assertJson([
                'status' => 'not_found',
                'message' => 'The resource brand with identifier 999999 does not exist.',
            ]);
    }

    #[Test]
    public function deletes_a_brand_successfully()
    {
        $brand = Brand::factory()->create([
            'name' => 'Old Brand',
            'image' => 'https://example.com/old.png',
            'rating' => 2,
        ]);

        $response = $this->withHeaders($this->headers)
            ->deleteJson("/api/brands/{$brand->id}");

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success'
            ]);
    }

    #[Test]
    public function returns_not_found_if_delete_brand_does_not_exist()
    {
        $response = $this->withHeaders($this->headers)
            ->deleteJson('/api/brands/999999');

        $response->assertStatus(404)
            ->assertJson([
                'status' => 'not_found',
                'message' => 'The resource brand with identifier 999999 does not exist.',
            ]);
    }

}
