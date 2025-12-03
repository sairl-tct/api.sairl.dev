<?php

declare(strict_types=1);

use App\Models\Status;

it('deletes a status', function (): void {
    // Arrange: one status exists
    $status = Status::factory()->create([
        'name' => 'In Progress',
        'description' => 'Task is currently being worked on',
    ]);

    // Act: send DELETE with id in URL
    $response = $this->deleteJson(
        route('api.v1.statuses.destroy', ['id' => $status->id])
    );

    // Assert HTTP + JSON
    $response->assertStatus(200)
        ->assertJsonPath('message', 'status deleted successfully');

    // Assert DB: no statuses left
    $this->assertDatabaseCount('statuses', 0);
});

it('responds with 404 when the status does not exist', function (): void {
    $status = Status::factory()->create();
    $fakeId = 999;
    // Act
    $response = $this->deleteJson(
        route('api.v1.statuses.destroy', ['id' => $fakeId])
    );

    // Assert
    $response->assertStatus(404)
        ->assertJsonPath('status', 'error')
        ->assertJsonPath('message', 'status not found');

    // Original status must still exist
    $this->assertDatabaseHas('statuses', [
        'id' => $status->id,
    ]);
});
