<?php

declare(strict_types=1);

use App\Actions\Queries\TeamCategories\GetTeamCategories;
use App\Models\TeamCategory;
use Illuminate\Database\Eloquent\Collection;

it('team category retrieved successfully', function (): void {
    // Arrange: 3 team category in DB
    TeamCategory::factory()->count(3)->create();

    // action: get action team categories
    $action = app(GetTeamCategories::class);
    $result = $action->handle();

    expect($result)
        ->toBeInstanceOf(Collection::class)
        ->and(count($result))->toBe(3);

    // optionally check type of first item
    expect($result->first())->toBeInstanceOf(TeamCategory::class);
});
