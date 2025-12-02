<?php

declare(strict_types=1);

use App\Models\Category;

/** @var Tests\TestCase $this */
it('delete a category', function (): void {
    // Arrange: one category exists
    $category = Category::factory()->create([
        'name' => 'Tech',
        'description' => 'Tech description',
    ]);

    // Act: send DELETE with UUID in URL
    $response = $this->deleteJson(
        route('api.v1.categories.destroy', ['uuid' => $category->id])
    );

    // Assert HTTP + JSON
    $response->assertStatus(200)
        ->assertJsonPath('message', 'category deleted successfully');

    // Assert DB: no categories left
    $this->assertDatabaseCount('categories', 0);
});

it('fail to delete a category', function (): void {
    // Arrange: create 1 real category
    Category::factory()->create([
        'name' => 'Tech',
        'description' => 'Tech description',
    ]);

    // Use a fake UUID that does NOT exist in DB
    $fakeUuid = '00000000-0000-0000-0000-000000000000';

    // Act
    $response = $this->deleteJson(
        route('api.v1.categories.destroy', ['uuid' => $fakeUuid])
    );

    // Assert HTTP + JSON
    $response->assertStatus(404)
        ->assertJsonPath('message', 'category not found');

    // Assert DB: still 1 category
    $this->assertDatabaseCount('categories', 1);
});
