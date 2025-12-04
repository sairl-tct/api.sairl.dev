<?php

declare(strict_types=1);

use App\Actions\TeamCategories\DeleteTeamCategory;
use App\Models\TeamCategory;

it('deletes a team category successfully', function (): void {
    // Arrange
    $teamCategory = TeamCategory::factory()->create([
        'name' => 'to be deleted',
        'description' => 'team category to be deleted',
    ]);

    // Act...
    $action = app(DeleteTeamCategory::class);
    $result = $action->handle($teamCategory->id);

    // Assert
    expect($result)->toBeTrue()
        ->and(TeamCategory::query()->find($teamCategory->id))->toBeNull();
});

it('returns false when team category does not exist', function (): void {
    $fackeId = 9999; // Non-existent ID

    // Act...
    $action = app(DeleteTeamCategory::class);
    $result = $action->handle($fackeId);

    // Assert
    expect($result)->toBeFalse();
});
