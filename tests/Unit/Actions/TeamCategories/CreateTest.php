<?php

declare(strict_types=1);

use App\Actions\TeamCategories\CreateTeamCategory;
use App\Models\TeamCategory;

it('creates a team category successfully', function (): void {
    // Arrange
    $payload = [
        'name' => 'test',
        'description' => 'test',
    ];

    // Act...
    $action = app(CreateTeamCategory::class);
    $teamCategory = $action->handle($payload);

    // Assert
    expect($teamCategory)
        ->toBeInstanceOf(TeamCategory::class)
        ->and($teamCategory->name)->toBe('test')
        ->and($teamCategory->description)->toBe('test')
        ->and(TeamCategory::query()->count())->toBe(1);
});
