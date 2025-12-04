<?php

declare(strict_types=1);

use App\Models\TeamTag;

it('updates a team tag successfully', function (): void {
    // Arrange: existing team tag
    $teamTag = TeamTag::factory()->create([
        'name' => 'In Progress',
    ]);

    $payload = [
        'name' => 'Completed',
    ];

    // Action: send PUT request to update team tag
    $response = $this->putJson(
        route('api.v1.team-tags.update', ['id' => $teamTag->id]),
        $payload
    );

    // Assert: HTTP + JSON response
    $response->assertStatus(200)
        ->assertJsonPath('status', 'success')
        ->assertJsonPath('message', 'Team tag successfully updated');
    // Assert: DB actually updated
    $this->assertDatabaseHas('team_tags', [
        'id' => $teamTag->id,
        'name' => 'Completed',
    ]);
});
