<?php 
declare(strict_types=1);

use App\Actions\Queries\Permissions\GetPermissions;
use App\Models\Permission;
use Illuminate\Database\Eloquent\Collection;

it('permission retrieved successfully', function (): void {
    // Arrange: 3 permissions in DB
    Permission::factory()->count(3)->create();

    // action: get action permissions
    $action = app(GetPermissions::class);
    $result = $action->handle();

    // Assert: structure & count
    expect($result)
        ->toBeInstanceOf(Collection::class)
        ->and(count($result))->toBe(3);

    // optionally check type of first item
    expect($result->first())->toBeInstanceOf(Permission::class);
});

it('returns empty collection when there are no permissions', function (): void {
    // Arrange: DB is empty (RefreshDatabase already handled this)

    // action: get action permissions
    $action = app(GetPermissions::class);
    $result = $action->handle();

    // Assert: empty collection
    expect($result)
        ->toBeInstanceOf(Collection::class)
        ->and($result)->toBeEmpty();
});