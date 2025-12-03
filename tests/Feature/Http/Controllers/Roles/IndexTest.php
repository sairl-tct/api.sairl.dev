<?php

declare(strict_types=1);

use App\Models\Role;

it('returns a list of roles', function (): void {
    // Arrange
    Role::factory(2)->create();

    // Act
    $response = $this->getJson(route('api.v1.roles.index'));

    // Assert
    expect($response->status())->toBe(200)
        ->and($response->json())->toHaveKeys(['message', 'status', 'data']);
});

it('returns 404 when no roles exist', function (): void {
    // No roles created here -> DB is empty
    // Act
    $response = $this->getJson(route('api.v1.roles.index'));

    // Assert
    $response->assertStatus(404)
        ->assertJsonPath('message', 'roles not found');
});
