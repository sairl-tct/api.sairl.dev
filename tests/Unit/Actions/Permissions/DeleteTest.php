<?php

declare(strict_types=1);

use App\Actions\Permissions\DeletePermission;
use App\Models\Permission;

it('deletes a permission successfully', function (): void {
    // Arrange: create a permission
    $permission = Permission::factory()->create([
        'name' => 'edit articles',
        'description' => 'Permission to edit articles',
    ]);

    // Act: call action with the UUID primary key
    $action = app(DeletePermission::class);
    $result = $action->handle($permission->id);

    // Assert: action returns true and record is deleted
    expect($result)->toBeTrue()
        ->and(Permission::query()->find($permission->id))->toBeNull();
});

it('returns false when permission does not exist', function (): void {
    // Arrange: some fake ID that doesn't exist
    $fakeId = 9999;
    // Act
    $action = app(DeletePermission::class);
    $result = $action->handle($fakeId);

    // Assert
    expect($result)->toBeFalse();
});
