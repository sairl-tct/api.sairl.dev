<?php

declare(strict_types=1);

use App\Actions\TeamCategories\UpdateTeamCategory;
use App\Models\TeamCategory;

it('update a team category successfully', function (): void {
    $teamCategory = TeamCategory::factory()->create([
        'name' => 'Open',
        'description' => 'The task is open',
    ]);

    $data = [
        'name' => 'Closed',
        'description' => 'The task is closed',
    ];

    $action = app(UpdateTeamCategory::class);
    $result = $action->handle($teamCategory->id, $data);
    expect($result)
        ->toBeArray()
        ->and($result['status'])->toBe('success')
        ->and($result['message'])->toBe('Team category updated successfully')
        ->and($result['code'])->toBe(200);
});

it('return error when team category is not found', function (): void {
    $fakeId = 9999;

    $data = [
        'name' => 'Closed',
        'description' => 'The task is closed',
    ];

    $action = app(UpdateTeamCategory::class);
    $result = $action->handle($fakeId, $data);

    expect($result)
        ->toBeArray()
        ->and($result['status'])->toBe('error')
        ->and($result['message'])->toBe('Team category not found')
        ->and($result['code'])->toBe(404);
});

it('return error when the name is duplicate', function (): void {
    $teamCategoryA = TeamCategory::factory()->create([
        'name' => 'Open',
        'description' => 'The task is open',
    ]);
    $teamCategoryB = TeamCategory::factory()->create([
        'name' => 'Closed',
        'description' => 'The task is closed',
    ]);

    $data = [
        'name' => 'Closed', // duplicate name
        'description' => 'Trying to duplicate name',
    ];
    $action = app(UpdateTeamCategory::class);
    $result = $action->handle($teamCategoryA->id, $data);

    expect($result)
        ->toBeArray()
        ->and($result['status'])->toBe('error')
        ->and($result['message'])->toBe('The name is already taken')
        ->and($result['code'])->toBe(422);
});
