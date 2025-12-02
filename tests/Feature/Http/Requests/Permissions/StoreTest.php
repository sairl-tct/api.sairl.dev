<?php

declare(strict_types=1);

use App\Http\Requests\Permissions\StorePermissionRequest;
use App\Models\Permission;

it('fails when name is missing', function (): void {
    // Arrange
    $request = new StorePermissionRequest;

    // Act
    $validator = validator()->make([
        // 'name' => 'edit articles', // missing name
        'description' => 'Permission to edit articles',
    ], $request->rules());

    // Assert
    expect($validator->fails())->toBeTrue()
        ->and($validator->errors())->toHaveKey('name');
});

it('fails when name is too short', function (): void {
    // Arrange
    $request = new StorePermissionRequest;

    // Act
    $validator = validator()->make([
        'name' => 'edc', // too short
        'description' => 'Permission to edit articles',
    ], $request->rules());

    // Assert
    expect($validator->fails())->toBeTrue()
        ->and($validator->errors())->toHaveKey('name');
});

it('fails when name is not a string', function (): void {
    // Arrange
    $request = new StorePermissionRequest;

    // Act
    $validator = validator()->make([
        'name' => 12345, // not a string
        'description' => 'Permission to edit articles',
    ], $request->rules());

    // Assert
    expect($validator->fails())->toBeTrue()
        ->and($validator->errors())->toHaveKey('name');
});

it('fails when name is to long', function (): void {
    // Arrange
    $request = new StorePermissionRequest;

    // Act
    $validator = validator()->make([
        'name' => str_repeat('a', 51), // too long
        'description' => 'Permission to edit articles',
    ], $request->rules());

    // Assert
    expect($validator->fails())->toBeTrue()
        ->and($validator->errors())->toHaveKey('name');
});

it('fails when name is not unique', function (): void {
    // Arrange
    Permission::factory()->create([
        'name' => 'edit articles',
    ]);

    $request = new StorePermissionRequest;

    // Act
    $validator = validator()->make([
        'name' => 'edit articles', // duplicate name
        'description' => 'Permission to edit articles',
    ], $request->rules());

    // Assert
    expect($validator->fails())->toBeTrue()
        ->and($validator->errors())->toHaveKey('name');
});

it('fails when description is too short', function (): void {
    // Arrange
    $request = new StorePermissionRequest;

    // Act
    $validator = validator()->make([
        'name' => 'edit articles',
        'description' => 'abc', // too short
    ], $request->rules());

    // Assert
    expect($validator->fails())->toBeTrue()
        ->and($validator->errors())->toHaveKey('description');
});

it('fails when description is too long', function (): void {
    // Arrange
    $request = new StorePermissionRequest;

    // Act
    $validator = validator()->make([
        'name' => 'edit articles',
        'description' => str_repeat('a', 256), // too long
    ], $request->rules());

    // Assert
    expect($validator->fails())->toBeTrue()
        ->and($validator->errors())->toHaveKey('description');
});

it('fails when description is not a string', function (): void {
    // Arrange
    $request = new StorePermissionRequest;

    // Act
    $validator = validator()->make([
        'name' => 'edit articles',
        'description' => 12345, // not a string
    ], $request->rules());

    // Assert
    expect($validator->fails())->toBeTrue()
        ->and($validator->errors())->toHaveKey('description');
});
