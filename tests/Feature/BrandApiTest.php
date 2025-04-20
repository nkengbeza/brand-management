<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class BrandApiTest extends TestCase
{

    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate');
    }

    #[Test]
    public function it_creates_a_successfully()
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
    public function it_returns_validation_messages_in_french()
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
    public function it_returns_validation_messages_in_english()
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
}
