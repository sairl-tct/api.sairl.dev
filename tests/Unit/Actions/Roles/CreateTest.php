<?php

declare(strict_types=1);

use App\Actions\Roles\CreateRole;
use App\Models\Role;

it('creates a role successfully', function (): void {
    // Arrange
    $payload = [
        'name' => 'test',
        'description' => 'test',
    ];

    // Act...
    $action = app(CreateRole::class);
    $role = $action->handle($payload);

    // Assert
    expect($role)
        ->toBeInstanceOf(Role::class)
        ->and($role->name)->toBe('test')
        ->and($role->description)->toBe('test')
        ->and(Role::query()->count())->toBe(1);
});
