<?php 
declare(strict_types=1);

use App\Models\Status;

it('updates a status successfully', function (): void {
    // Arrange: existing status
    $status = Status::factory()->create([
        'name' => 'In Progress',
    ]);

    $payload = [
        'name' => 'Completed',
    ];

    // Action: send PUT request to update status
    $response = $this->putJson(
        route('api.v1.statuses.update', ['id' => $status->id]),
        $payload
    );

    // Assert: HTTP + JSON response
    $response->assertStatus(200)
        ->assertJsonPath('status', 'success')
        ->assertJsonPath('message', 'update status successfully');

    // Assert: DB actually updated
    $this->assertDatabaseHas('statuses', [
        'id' => $status->id,
        'name' => 'Completed',
    ]);
});