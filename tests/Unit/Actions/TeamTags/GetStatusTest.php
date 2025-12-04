<?php

declare(strict_types=1);

use App\Actions\Queries\TeamTags\GetTeamTag;
use App\Models\TeamTag;

it('returns a single team tag', function (): void {
    // Arrange: create a team tag in DB
    $teamTag = TeamTag::factory()->create([
        'name' => 'In Progress',
        'description' => 'Task is currently being worked on',
    ]);

    // Act: call action with id
    $action = app(GetTeamTag::class);
    $result = $action->handle($teamTag->id);

    // Assert
    expect($result)
        ->toBeInstanceOf(TeamTag::class)
        ->and($result->id)->toBe($teamTag->id)
        ->and($result->name)->toBe('In Progress')
        ->and($result->description)->toBe('Task is currently being worked on');
});

it('returns null when status is not found', function (): void {
    // Arrange: some fake ID not in DB
    $fakeId = 9999;

    // Act
    $action = app(GetTeamTag::class);
    $result = $action->handle($fakeId);

    // Assert
    expect($result)->toBeNull();
});
