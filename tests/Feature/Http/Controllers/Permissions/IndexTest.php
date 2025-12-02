<?php

declare(strict_types=1);

use App\Models\Permission;

it('returns a list of permissions', function (): void {
    // Arrange
    Permission::factory(2)->create();

    // Act
    $response = $this->getJson(route('api.v1.permissions.index'));

    // Assert
    expect($response->status())->toBe(200)
        ->and($response->json())->toHaveKeys(['message', 'status', 'data']);
});

it('returns 404 when no permissions exist', function (): void {
    // No permissions created here -> DB is empty

    // Act
    $response = $this->getJson(route('api.v1.permissions.index'));

    // Assert
    $response->assertStatus(404)
        ->assertJsonPath('message', 'permissions not found');
});
