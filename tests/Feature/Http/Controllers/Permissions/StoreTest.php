<?php

declare(strict_types=1);

use App\Models\Permission;

it('creates a new permission', function (): void {
    $payload = [
        'name' => 'manage users',
    ];

    $response = $this->postJson(route('api.v1.permissions.store'), $payload);

    $response->assertStatus(201);

    $this->assertDatabaseHas('permissions', ['name' => 'manage users']);
});

it('fails to create a permission with duplicate name', function (): void {
    // Arrange: existing permission
    $a = Permission::factory()->create([
        'name' => 'view reports',
    ]);

    $payload = [
        'name' => 'view reports', // duplicate name
    ];

    $response = $this->postJson(route('api.v1.permissions.store'), $payload);

    // Assert: validation error on `name`
    $response->assertStatus(422)
        ->assertJsonValidationErrors(['name']);
    // Optional:
    // ->assertJsonPath('message', 'The name has already been taken.');
});

it('fails to create a permission with invalid data', function (): void {
    $payload = [
        'name' => '', // invalid: empty name
    ];

    $response = $this->postJson(route('api.v1.permissions.store'), $payload);

    // Assert: validation error on `name`
    $response->assertStatus(422)
        ->assertJsonValidationErrors(['name']);
    // Optional:
    // ->assertJsonPath('message', 'The name field is required.');
});
