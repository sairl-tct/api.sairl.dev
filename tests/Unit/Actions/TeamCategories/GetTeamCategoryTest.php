<?php

declare(strict_types=1);

use App\Actions\Queries\TeamCategories\GetTeamCategory;
use App\Models\TeamCategory;

it('returns a single team category', function (): void {
    // Arrange: create a team category in DB
    $teamCategory = TeamCategory::factory()->create([
        'name' => 'In Progress',
        'description' => 'Task is currently being worked on',
    ]);

    // Act: call action with id
    $action = app(GetTeamCategory::class);
    $result = $action->handle($teamCategory->id);

    // Assert
    expect($result)
        ->toBeInstanceOf(TeamCategory::class)
        ->and($result->id)->toBe($teamCategory->id)
        ->and($result->name)->toBe('In Progress')
        ->and($result->description)->toBe('Task is currently being worked on');
});

it('returns null when status is not found', function (): void {
    // Arrange: some fake ID not in DB
    $fakeId = 9999;

    // Act
    $action = app(GetTeamCategory::class);
    $result = $action->handle($fakeId);

    // Assert
    expect($result)->toBeNull();
});
