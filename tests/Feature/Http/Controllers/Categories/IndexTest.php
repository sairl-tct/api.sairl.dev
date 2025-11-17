<?php

declare(strict_types=1);

use App\Models\Category;

it('may be list of categories', function (): void {
    Category::factory(2)->create();

    $response = $this->getJson(route('api.v1.categories.index'));

    expect($response->status())->toBe(200)
        ->and($response->json())->toHaveKeys(['message', 'status', 'data']);
});

it('may be empty list of category', function (): void {
    // No categories created here -> DB is empty

    $response = $this->getJson(route('api.v1.categories.index'));

    $response->assertStatus(404)
        ->assertJsonPath('message', 'categories not found');
}); 