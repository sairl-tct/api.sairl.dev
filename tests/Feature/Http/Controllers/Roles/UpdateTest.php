<?php

declare(strict_types=1);

use App\Models\Role;

it('updates a role successfully', function (): void {
    // Arrange: existing roles
    $role = Role::factory()->create([
        'name' => 'In Progress',
    ]);

    $payload = [
        'name' => 'Completed',
    ];

    // Action: send PUT request to update role
    $response = $this->putJson(
        route('api.v1.roles.update', ['id' => $role->id]),
        $payload
    );

    // Assert: HTTP + JSON response
    $response->assertStatus(200)
        ->assertJsonPath('status', 'success')
        ->assertJsonPath('message', 'role updated successfully');

    // Assert: DB actually updated
    $this->assertDatabaseHas('roles', [
        'id' => $role->id,
        'name' => 'Completed',
    ]);
});
