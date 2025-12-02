<?php 
declare(strict_types=1);

use App\Models\Permission;

it('deletes a permission', function (): void {
    // Arrange: one permission exists
    $permission = Permission::factory()->create([
        'name' => 'edit articles',
        'description' => 'Edit articles permission',
    ]);

    // Act: send DELETE with id in URL
    $response = $this->deleteJson(
        route('api.v1.permissions.destroy', ['id' => $permission->id])
    );

    // Assert HTTP + JSON
    $response->assertStatus(200)
        ->assertJsonPath('message', 'permission deleted successfully');

    // Assert DB: no permissions left
    $this->assertDatabaseCount('permissions', 0);
});

it('returns 404 when permission is not found', function (): void {
    // Arrange: create one permission, but delete using a non-existing id
    $existing = Permission::factory()->create();

    $missingId = ($existing->id ?? 0) + 1;

    // Act
    $response = $this->deleteJson(
        route('api.v1.permissions.destroy', ['id' => $missingId])
    );

    // Assert
    $response->assertStatus(404)
        ->assertJsonPath('status', 'error')
        ->assertJsonPath('message', 'permission not found');

    // Original permission must still exist
    $this->assertDatabaseHas('permissions', [
        'id' => $existing->id,
    ]);
});