<?php 
declare(strict_types=1);

use App\Models\Role;

it('has fillable properties', function () {
    $role = new Role();

    expect($role->getFillable())->toBe([
        'name',
        'description',
    ]);
});

test('to array', function (): void {

    $role = Role::factory()->create()->fresh();

    expect(array_keys($role->toArray()))->toBe([
        'id',
        'name',
        'description',
        'created_at',
        'updated_at',
    ]);
});