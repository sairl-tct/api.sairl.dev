<?php

declare(strict_types=1);

use App\Models\Permission;

/** @var Tests\TestCase $this */
it('updates a permission successfully', function (): void {
    // Arrange: existing permission
    $permission = Permission::factory()->create([
        'name' => 'edit articles',
    ]);

    $payload = [
        'name' => 'edit news articles',
    ];

    // Action: send PUT request to update permission
    $response = $this->putJson(
        route('api.v1.permissions.update', ['id' => $permission->id]),
        $payload
    );

    // Assert: HTTP + JSON response
    $response->assertStatus(200)
        ->assertJsonPath('status', 'success')
        ->assertJsonPath('message', 'update permission successfully');

    // Assert: DB actually updated
    $this->assertDatabaseHas('permissions', [
        'id' => $permission->id,
        'name' => 'edit news articles',
    ]);
});

it('returns 404 when permission is not found', function (): void {
    // Arrange: an ID that does not exist in the test DB
    $id = 999;

    $payload = [
        'name' => 'some name',
    ];

    // Action
    $response = $this->putJson(
        route('api.v1.permissions.update', ['id' => $id]),
        $payload
    );

    // Assert
    $response->assertStatus(404)
        ->assertJsonPath('status', 'error')
        ->assertJsonPath('message', 'Permission not found');
});

it('returns 422 when updating with a duplicate name', function (): void {
    // Arrange: Permission A with name "edit articles"
    $existing = Permission::factory()->create([
        'name' => 'edit articles',
    ]);

    // Permission B we will try to update to same name
    $toUpdate = Permission::factory()->create([
        'name' => 'edit news articles',
    ]);

    $payload = [
        'name' => 'edit articles', // duplicate of $existing->name
    ];

    // Action
    $response = $this->putJson(
        route('api.v1.permissions.update', ['id' => $toUpdate->id]),
        $payload
    );

    // Assert
    $response->assertStatus(422)
        ->assertJsonPath('status', 'error');
    // If your UpdatePermission action returns a specific message:
    // ->assertJsonPath('message', 'The name has already been taken.');
});
