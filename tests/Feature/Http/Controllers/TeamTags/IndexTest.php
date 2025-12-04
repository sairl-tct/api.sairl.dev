<?php

declare(strict_types=1);

use App\Models\Tag;
use App\Models\TeamTag;

it('returns a list of tags', function (): void {
    // Arrange
    TeamTag::factory(2)->create();

    // Act
    $response = $this->getJson(route('api.v1.team-tags.index'));

    // Assert
    expect($response->status())->toBe(200)
        ->and($response->json())->toHaveKeys(['message', 'status', 'data']);
});

it('returns 404 when no team tags exist', function (): void {
    // No team tags created here -> DB is empty

    // Act
    $response = $this->getJson(route('api.v1.team-tags.index'));
    // Assert
    $response->assertStatus(404)
        ->assertJsonPath('message', 'team tags not found');
});
