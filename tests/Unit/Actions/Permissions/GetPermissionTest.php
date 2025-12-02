<?php

declare(strict_types=1);

use App\Actions\Queries\Permissions\GetPermission;
use App\Models\Permission;

it('returns a single permission', function (): void {
    // Arrange: create a permission
    $permission = Permission::factory()->create([
        'name' => 'edit articles',
        'description' => 'Allows editing of articles',
    ]);

    // Act: call action with id
    $action = app(GetPermission::class);
    $result = $action->handle($permission->id);

    // Assert
    expect($result)
        ->toBeInstanceOf(Permission::class)
        ->and($result->id)->toBe($permission->id)
        ->and($result->name)->toBe('edit articles')
        ->and($result->description)->toBe('Allows editing of articles');
});

it('returns null when permission is not found', function (): void {
    // Arrange: some fake ID not in DB
    $fakeId = 9999;

    // Act
    $action = app(GetPermission::class);
    $result = $action->handle($fakeId);

    // Assert
    expect($result)->toBeNull();
});
