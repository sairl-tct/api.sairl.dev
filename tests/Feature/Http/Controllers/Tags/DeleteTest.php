<?php

declare(strict_types=1);

use App\Models\Status;
use App\Models\Tag;

it('deletes a tag', function (): void {
    // Arrange: one tag exists
    $tag = Tag::factory()->create([
        'name' => 'In Progress',
        'description' => 'Task is currently being worked on',
    ]);

    // Act: send DELETE with id in URL
    $response = $this->deleteJson(
        route('api.v1.tags.destroy', ['id' => $tag->id])
    );

    // Assert HTTP + JSON
    $response->assertStatus(200)
        ->assertJsonPath('message', 'tag deleted successfully');
    // Assert DB: no statuses left
    $this->assertDatabaseCount('tags', 0);
});

it('responds with 404 when the tag does not exist', function (): void {
    $tag = Tag::factory()->create();
    $fakeId = 999;
    // Act
    $response = $this->deleteJson(
        route('api.v1.tags.destroy', ['id' => $fakeId])
    );

    // Assert
    $response->assertStatus(404)
        ->assertJsonPath('status', 'error')
        ->assertJsonPath('message', 'tag not found');

    // Original tag must still exist
    $this->assertDatabaseHas('tags', [
        'id' => $tag->id,
    ]);
});
