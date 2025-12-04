<?php

declare(strict_types=1);

use App\Actions\Queries\Tags\GetTag;
use App\Models\Tag;

it('returns a single status', function (): void {
    // Arrange: create a tag
    $tag = Tag::factory()->create([
        'name' => 'In Progress',
        'description' => 'Task is currently being worked on',
    ]);

    // Act: call action with id
    $action = app(GetTag::class);
    $result = $action->handle($tag->id);

    // Assert
    expect($result)
        ->toBeInstanceOf(Tag::class)
        ->and($result->id)->toBe($tag->id)
        ->and($result->name)->toBe('In Progress')
        ->and($result->description)->toBe('Task is currently being worked on');
});

it('returns null when status is not found', function (): void {
    // Arrange: some fake ID not in DB
    $fakeId = 9999;

    // Act
    $action = app(GetTag::class);
    $result = $action->handle($fakeId);

    // Assert
    expect($result)->toBeNull();
});
