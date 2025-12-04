<?php

declare(strict_types=1);

use App\Models\TeamTag;

it('deletes a team tag', function (): void {
    // Arrange: one team tag exists
    $teamTag = TeamTag::factory()->create([
        'name' => 'In Progress',
        'description' => 'Task is currently being worked on',
    ]);

    // Act: send DELETE with id in URL
    $response = $this->deleteJson(
        route('api.v1.team-tags.destroy', ['id' => $teamTag->id])
    );

    // Assert HTTP + JSON
    $response->assertStatus(200)
        ->assertJsonPath('message', 'team tag deleted successfully');
    // Assert DB: no team tags left
    $this->assertDatabaseCount('team_tags', 0);
});

it('responds with 404 when the team tag does not exist', function (): void {
    $teamTag = TeamTag::factory()->create();
    $fakeId = 999;
    // Act
    $response = $this->deleteJson(
        route('api.v1.team-tags.destroy', ['id' => $fakeId])
    );

    // Assert
    $response->assertStatus(404)
        ->assertJsonPath('status', 'error')
        ->assertJsonPath('message', 'team tag not found');

    // Original team tag must still exist
    $this->assertDatabaseHas('team_tags', [
        'id' => $teamTag->id,
    ]);
});
