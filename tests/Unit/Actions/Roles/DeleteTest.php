<?php

declare(strict_types=1);

use App\Actions\Roles\DeleteRole;
use App\Models\Role;

it('deletes a role successfully', function (): void {
    // Arrange
    $role = Role::factory()->create([
        'name' => 'to be deleted',
        'description' => 'role to be deleted',
    ]);

    // Act...
    $action = app(DeleteRole::class);
    $result = $action->handle($role->id);

    // Assert
    expect($result)->toBeTrue()
        ->and(Role::query()->find($role->id))->toBeNull();
});

it('returns false when role does not exist', function (): void {
    $fackeId = 9999; // Non-existent ID

    // Act...
    $action = app(DeleteRole::class);
    $result = $action->handle($fackeId);

    // Assert
    expect($result)->toBeFalse();
});
