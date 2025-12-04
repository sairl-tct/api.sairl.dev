<?php

declare(strict_types=1);

use App\Models\Tag;

it('updates a tag successfully', function (): void {
    // Arrange: existing tag
    $tag = Tag::factory()->create([
        'name' => 'In Progress',
    ]);

    $payload = [
        'name' => 'Completed',
    ];

    // Action: send PUT request to update tag
    $response = $this->putJson(
        route('api.v1.tags.update', ['id' => $tag->id]),
        $payload
    );

    // Assert: HTTP + JSON response
    $response->assertStatus(200)
        ->assertJsonPath('status', 'success')
        ->assertJsonPath('message', 'Tag updated successfully');

    // Assert: DB actually updated
    $this->assertDatabaseHas('tags', [
        'id' => $tag->id,
        'name' => 'Completed',
    ]);
});
