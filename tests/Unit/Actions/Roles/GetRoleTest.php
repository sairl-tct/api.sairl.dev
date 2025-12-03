<?php

declare(strict_types=1);

use App\Actions\Queries\Roles\GetRole;
use App\Models\Role;

it('returns a single role', function (): void {
    // Arrange: create a role
    $status = Role::factory()->create([
        'name' => 'In Progress',
        'description' => 'Task is currently being worked on',
    ]);

    // Act: call action with id
    $action = app(GetRole::class);
    $result = $action->handle($status->id);

    // Assert
    expect($result)
        ->toBeInstanceOf(Role::class)
        ->and($result->id)->toBe($status->id)
        ->and($result->name)->toBe('In Progress')
        ->and($result->description)->toBe('Task is currently being worked on');
});

it('returns null when status is not found', function (): void {
    // Arrange: some fake ID not in DB
    $fakeId = 9999;

    // Act
    $action = app(GetRole::class);
    $result = $action->handle($fakeId);

    // Assert
    expect($result)->toBeNull();
});
