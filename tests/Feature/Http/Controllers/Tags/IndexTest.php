<?php

declare(strict_types=1);

use App\Models\Tag;

it('returns a list of tags', function (): void {
    // Arrange
    Tag::factory(2)->create();

    // Act
    $response = $this->getJson(route('api.v1.tags.index'));

    // Assert
    expect($response->status())->toBe(200)
        ->and($response->json())->toHaveKeys(['message', 'status', 'data']);
});

it('returns 404 when no tags exist', function (): void {
    // No tags created here -> DB is empty

    // Act
    $response = $this->getJson(route('api.v1.tags.index'));

    // Assert
    $response->assertStatus(404)
        ->assertJsonPath('message', 'Tags not found');
});
