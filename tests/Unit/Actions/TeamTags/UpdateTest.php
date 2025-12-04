<?php

declare(strict_types=1);

use App\Actions\Tags\UpdateTag;
use App\Actions\TeamTags\UpdateTeamTag;
use App\Models\Tag;
use App\Models\TeamTag;

it('update a team tag successfully', function (): void {
    $teamTag = TeamTag::factory()->create([
        'name' => 'Open',
        'description' => 'The task is open',
    ]);

    $data = [
        'name' => 'Closed',
        'description' => 'The task is closed',
    ];

    $action = app(UpdateTeamTag::class);
    $result = $action->handle($teamTag->id, $data);
    expect($result)
        ->toBeArray()
        ->and($result['status'])->toBe('success')
        ->and($result['message'])->toBe('Team tag successfully updated')
        ->and($result['code'])->toBe(200);
});

it('return error when team tag is not found', function (): void {
    $fakeId = 9999;

    $data = [
        'name' => 'Closed',
        'description' => 'The task is closed',
    ];

    $action = app(UpdateTeamTag::class);
    $result = $action->handle($fakeId, $data);

    expect($result)
        ->toBeArray()
        ->and($result['status'])->toBe('error')
        ->and($result['message'])->toBe('Team tag not found')
        ->and($result['code'])->toBe(404);
});

it('return error when the name is duplicate', function (): void {
    $teamTagA = TeamTag::factory()->create([
        'name' => 'Open',
        'description' => 'The task is open',
    ]);
    $teamTagB = TeamTag::factory()->create([
        'name' => 'Closed',
        'description' => 'The task is closed',
    ]);

    $data = [
        'name' => 'Closed', // duplicate name
        'description' => 'Trying to duplicate name',
    ];
    $action = app(UpdateTeamTag::class);
    $result = $action->handle($teamTagA->id, $data);

    expect($result)
        ->toBeArray()
        ->and($result['status'])->toBe('error')
        ->and($result['message'])->toBe('The name is already taken')
        ->and($result['code'])->toBe(422);
});
