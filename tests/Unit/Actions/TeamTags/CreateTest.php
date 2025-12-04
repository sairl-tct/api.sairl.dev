<?php

declare(strict_types=1);
use App\Actions\TeamTags\CreateTeamTag;
use App\Models\TeamTag;

it('creates a team tag successfully', function (): void {
    // Arrange
    $payload = [
        'name' => 'test',
        'description' => 'test',
    ];

    // Act...
    $action = app(CreateTeamTag::class);
    $teamTag = $action->handle($payload);

    // Assert
    expect($teamTag)
        ->toBeInstanceOf(TeamTag::class)
        ->and($teamTag->name)->toBe('test')
        ->and($teamTag->description)->toBe('test')
        ->and(TeamTag::query()->count())->toBe(1);
});
