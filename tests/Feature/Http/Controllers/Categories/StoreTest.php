<?php

declare(strict_types=1);

use App\Models\Category;

it('create a new category', function (): void {
    $payload = [
        'name' => 'Business',
    ];

    $response = $this->postJson(route('api.v1.categories.store'), $payload);

    $response->assertStatus(201);

    $this->assertDatabaseHas('categories', ['name' => 'Business']);
});

it('it fails to create a category with duplicate name', function (): void {
    // Arrange: existing category
    Category::factory()->create([
        'name' => 'Tech',
    ]);

    $payload = [
        'name' => 'Tech', // duplicate name
    ];

    $response = $this->postJson(route('api.v1.categories.store'), $payload);

    // Assert: validation error on `name`
    $response->assertStatus(422)
        ->assertJsonValidationErrors(['name']);
    // Optional:
    // ->assertJsonPath('message', 'The name has already been taken.');
});
