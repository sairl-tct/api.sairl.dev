<?php

declare(strict_types=1);

use App\Actions\Queries\Roles\GetRoles;
use App\Models\Role;
use Illuminate\Database\Eloquent\Collection;

it('roles retrieved successfully', function (): void {
    // Arrange: 3 roles in DB
    Role::factory()->count(3)->create();

    // action: get action roles
    $action = app(GetRoles::class);
    $result = $action->handle();

    expect($result)
        ->toBeInstanceOf(Collection::class)
        ->and(count($result))->toBe(3);

    // optionally check type of first item
    expect($result->first())->toBeInstanceOf(Role::class);
});
