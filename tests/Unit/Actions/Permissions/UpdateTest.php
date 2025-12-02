<?php 
declare(strict_types=1);

use App\Actions\Permissions\UpdatePermission;
use App\Models\Permission;

it('update a permission successfully', function (): void {
    // Arrange: create a permission
    $permission = Permission::factory()->create([
        'name' => 'edit articles',
        'description' => 'Allows editing of articles',
    ]);

    // New data for update
    $data = [
        'name' => 'edit news',
        'description' => 'Allows editing of news articles',
    ];

    // Act: call update action
    $action = app(UpdatePermission::class);
    $result = $action->handle($permission->id, $data);

    // Assert response structure
    expect($result)
        ->toBeArray()
        ->and($result['status'])->toBe('success')
        ->and($result['message'])->toBe('update permission successfully')
        ->and($result['code'])->toBe(200);

    // Assert DB actually updated
    $this->assertDatabaseHas('permissions', [
        'id' => $permission->id,
        'name' => 'edit news',
        'description' => 'Allows editing of news articles',
    ]);
});

it('return error when permission is not found', function (): void {
    // fake ID that does not exist
    $fakeId = 9999;

    $data = [
        'name' => 'edit news',
        'description' => 'Allows editing of news articles',
    ];

    $action = app(UpdatePermission::class);
    $result = $action->handle($fakeId, $data);

    expect($result)
        ->toBeArray()
        ->and($result['status'])->toBe('error')
        ->and($result['message'])->toBe('Permission not found')
        ->and($result['code'])->toBe(404);
});

it('return error when the name is duplicate', function (): void {
    // Permission A with name "edit articles"
    $permissionA = Permission::factory()->create([
        'name' => 'edit articles',
        'description' => 'Allows editing of articles',
    ]);

    // Permission B with name "edit news"
    $permissionB = Permission::factory()->create([
        'name' => 'edit news',
        'description' => 'Allows editing of news articles',
    ]);

    // Attempt to update Permission B to have the same name as Permission A
    $data = [
        'name' => 'edit articles', // duplicate name
        'description' => 'Updated description',
    ];

    $action = app(UpdatePermission::class);
    $result = $action->handle($permissionB->id, $data);

    expect($result)
        ->toBeArray()
        ->and($result['status'])->toBe('error')
        ->and($result['message'])->toBe('The name has already been taken.')
        ->and($result['code'])->toBe(422);
});