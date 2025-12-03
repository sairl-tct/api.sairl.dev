<?php

declare(strict_types=1);

use App\Actions\Queries\Statuses\GetStatus;
use App\Models\Status;

it('returns a single status', function (): void {
    // Arrange: create a status
    $status = Status::factory()->create([
        'name' => 'In Progress',
        'description' => 'Task is currently being worked on',
    ]);

    // Act: call action with id
    $action = app(GetStatus::class);
    $result = $action->handle($status->id);

    // Assert
    expect($result)
        ->toBeInstanceOf(Status::class)
        ->and($result->id)->toBe($status->id)
        ->and($result->name)->toBe('In Progress')
        ->and($result->description)->toBe('Task is currently being worked on');
});

it('returns null when status is not found', function (): void {
    // Arrange: some fake ID not in DB
    $fakeId = 9999;

    // Act
    $action = app(GetStatus::class);
    $result = $action->handle($fakeId);

    // Assert
    expect($result)->toBeNull();
});
