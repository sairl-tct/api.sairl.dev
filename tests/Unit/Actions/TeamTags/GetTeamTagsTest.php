<?php

declare(strict_types=1);

use App\Actions\Queries\TeamTags\GetTeamTags;
use App\Models\TeamTag;
use Illuminate\Database\Eloquent\Collection;

it('team tag retrieved successfully', function (): void {
    // Arrange: 3 team tags in DB
    TeamTag::factory()->count(3)->create();

    // action: get action team tags
    $action = app(GetTeamTags::class);
    $result = $action->handle();

    expect($result)
        ->toBeInstanceOf(Collection::class)
        ->and(count($result))->toBe(3);

    // optionally check type of first item
    expect($result->first())->toBeInstanceOf(TeamTag::class);
});
