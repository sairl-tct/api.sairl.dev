<?php

declare(strict_types=1);

use App\Models\Category;

it('updates a category successfully', function (): void {
    // Arrange: existing category
    $category = Category::factory()->create([
        'name' => 'tech',
        'description' => 'Old description',
    ]);

    $payload = [
        'name' => 'Business',
        'description' => 'New description',
    ];

    // Action: send PUT request to update category
    $response = $this->putJson(
        route('api.v1.categories.update', ['uuid' => $category->id]),
        $payload
    );

    // Assert: HTTP + JSON response
    $response->assertStatus(200)
        ->assertJsonPath('status', 'success')
        ->assertJsonPath('message', 'category updated successfully');

    // Assert: DB actually updated
    $this->assertDatabaseHas('categories', [
        'id' => $category->id,
        'name' => 'Business',
        'description' => 'New description',
    ]);
});

it('returns 404 when category is not found', function (): void {
    $payload = [
        'name' => 'Business',
        'description' => 'New description',
    ];

    $response = $this->putJson(
        route('api.v1.categories.update', ['uuid' => '00000000-0000-0000-0000-000000000000']),
        $payload
    );

    // Assert: HTTP + JSON response
    $response->assertStatus(404)
        ->assertJsonPath('status', 'error')
        ->assertJsonPath('message', 'Category not found.');
});

it('returns 422 when updating with a duplicate name', function (): void {
    // Arrange:
    // Category A with name 'Tech'
    Category::factory()->create([
        'name' => 'Tech',
    ]);

    // Category B that we will try to update to 'Tech'
    $categoryToUpdate = Category::factory()->create([
        'name' => 'Business',
    ]);

    $payload = [
        'name' => 'Tech', // Duplicate name
    ];

    // Action: send PUT request to update category
    $response = $this->putJson(
        route('api.v1.categories.update', ['uuid' => $categoryToUpdate->id]),
        $payload
    );

    // Assert: HTTP + JSON response
    $response->assertStatus(422)
        ->assertJsonPath('status', 'error')
        ->assertJsonPath('message', 'The category has already been taken.');

    // Make sur B still has old name in DB
    $this->assertDatabaseHas('categories', [
        'id' => $categoryToUpdate->id,
        'name' => 'Business',
    ]);
});
