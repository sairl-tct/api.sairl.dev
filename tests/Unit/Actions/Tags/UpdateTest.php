<?php

declare(strict_types=1);

use App\Actions\Statuses\UpdateStatus;
use App\Actions\Tags\UpdateTag;
use App\Models\Status;
use App\Models\Tag;

it('update a tag successfully', function (): void {
    $tag = Tag::factory()->create([
        'name' => 'Open',
        'description' => 'The task is open',
    ]);

    $data = [
        'name' => 'Closed',
        'description' => 'The task is closed',
    ];

    $action = app(UpdateTag::class);
    $result = $action->handle($tag->id, $data);
    expect($result)
        ->toBeArray()
        ->and($result['status'])->toBe('success')
        ->and($result['message'])->toBe('Tag updated successfully')
        ->and($result['code'])->toBe(200);
});

it('return error when tag is not found', function (): void {
    $fakeId = 9999;

    $data = [
        'name' => 'Closed',
        'description' => 'The task is closed',
    ];

    $action = app(UpdateTag::class);
    $result = $action->handle($fakeId, $data);

    expect($result)
        ->toBeArray()
        ->and($result['status'])->toBe('error')
        ->and($result['message'])->toBe('Tag not found')
        ->and($result['code'])->toBe(404);
});

it('return error when the name is duplicate', function (): void {
    $tagA = Tag::factory()->create([
        'name' => 'Open',
        'description' => 'The task is open',
    ]);
    $tagB = Tag::factory()->create([
        'name' => 'Closed',
        'description' => 'The task is closed',
    ]);

    $data = [
        'name' => 'Closed', // duplicate name
        'description' => 'Trying to duplicate name',
    ];
    $action = app(UpdateTag::class);
    $result = $action->handle($tagA->id, $data);

    expect($result)
        ->toBeArray()
        ->and($result['status'])->toBe('error')
        ->and($result['message'])->toBe('The name has already been taken')
        ->and($result['code'])->toBe(422);
});
