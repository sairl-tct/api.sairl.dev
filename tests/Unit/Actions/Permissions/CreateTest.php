<?php

declare(strict_types=1);

use App\Actions\Permissions\CreatePermission;
use App\Models\Permission;
use Illuminate\Database\QueryException;

it('creates a permission successfully', function (): void {
    // Test implementation goes here
    $action = app(CreatePermission::class);

    $permission = $action->handle([
        'name' => 'edit articles',
        'description' => 'Allows editing of articles',
    ]);
    expect($permission)->toBeInstanceOf(Permission::class)
        ->and($permission->name)->toBe('edit articles')
        ->and(Permission::query()->count())->toBe(1);
});

it('throws an exception when creating a permission with a duplicate name', function (): void {
    $action = app(CreatePermission::class);

    // Create the first permission
    $action->handle([
        'name' => 'edit articles',
        'description' => 'Allows editing of articles',
    ]);

    // Attempt to create a duplicate permission
    $action->handle([
        'name' => 'edit articles',
        'description' => 'Duplicate permission',
    ]);
})->throws(QueryException::class);
