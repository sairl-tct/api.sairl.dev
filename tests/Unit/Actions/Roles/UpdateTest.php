<?php

declare(strict_types=1);

use App\Actions\Roles\UpdateRole;
use App\Models\Role;

it('update a status successfully', function (): void {
    $status = Role::factory()->create([
        'name' => 'Open',
        'description' => 'The task is open',
    ]);

    $data = [
        'name' => 'Closed',
        'description' => 'The task is closed',
    ];

    $action = app(UpdateRole::class);
    $result = $action->handle($status->id, $data);
    expect($result)
        ->toBeArray()
        ->and($result['status'])->toBe('success')
        ->and($result['message'])->toBe('role updated successfully')
        ->and($result['code'])->toBe(200);
});

it('return error when role is not found', function (): void {
    $fakeId = 9999;

    $data = [
        'name' => 'Closed',
        'description' => 'The task is closed',
    ];

    $action = app(UpdateRole::class);
    $result = $action->handle($fakeId, $data);

    expect($result)
        ->toBeArray()
        ->and($result['status'])->toBe('error')
        ->and($result['message'])->toBe('Role not found.')
        ->and($result['code'])->toBe(404);
});

it('return error when the name is duplicate', function (): void {
    $roleA = Role::factory()->create([
        'name' => 'Open',
        'description' => 'The task is open',
    ]);
    $roleB = Role::factory()->create([
        'name' => 'Closed',
        'description' => 'The task is closed',
    ]);

    $data = [
        'name' => 'Closed', // duplicate name
        'description' => 'Trying to duplicate name',
    ];
    $action = app(UpdateRole::class);
    $result = $action->handle($roleA->id, $data);

    expect($result)
        ->toBeArray()
        ->and($result['status'])->toBe('error')
        ->and($result['message'])->toBe('The name has already been taken.')
        ->and($result['code'])->toBe(422);
});
