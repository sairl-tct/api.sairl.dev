<?php

declare(strict_types=1);

use App\Models\Role;

it('deletes a role', function (): void {
    // Arrange: one status exists
    $status = Role::factory()->create([
        'name' => 'In Progress',
        'description' => 'Task is currently being worked on',
    ]);

    // Act: send DELETE with id in URL
    $response = $this->deleteJson(
        route('api.v1.roles.destroy', ['id' => $status->id])
    );

    // Assert HTTP + JSON
    $response->assertStatus(200)
        ->assertJsonPath('message', 'role deleted successfully');

    // Assert DB: no roles left
    $this->assertDatabaseCount('roles', 0);
});

it('responds with 404 when the role does not exist', function (): void {
    $role = Role::factory()->create();
    $fakeId = 999;
    // Act
    $response = $this->deleteJson(
        route('api.v1.roles.destroy', ['id' => $fakeId])
    );

    // Assert
    $response->assertStatus(404)
        ->assertJsonPath('status', 'error')
        ->assertJsonPath('message', 'role not found');

    // Original role must still exist
    $this->assertDatabaseHas('roles', [
        'id' => $role->id,
    ]);
});
