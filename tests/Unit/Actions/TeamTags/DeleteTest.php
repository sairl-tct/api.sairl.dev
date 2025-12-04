<?php

declare(strict_types=1);

use App\Actions\TeamTags\DeleteTeamTag;
use App\Models\TeamTag;

it('deletes a team tag successfully', function (): void {
    // Arrange
    $teamTag = TeamTag::factory()->create([
        'name' => 'to be deleted',
        'description' => 'team tag to be deleted',
    ]);

    // Act...
    $action = app(DeleteTeamTag::class);
    $result = $action->handle($teamTag->id);

    // Assert
    expect($result)->toBeTrue()
        ->and(TeamTag::query()->find($teamTag->id))->toBeNull();
});

it('returns false when team tag does not exist', function (): void {
    $fackeId = 9999; // Non-existent ID

    // Act...
    $action = app(DeleteTeamTag::class);
    $result = $action->handle($fackeId);

    // Assert
    expect($result)->toBeFalse();
});
