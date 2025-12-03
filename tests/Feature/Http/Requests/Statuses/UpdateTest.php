<?php

declare(strict_types=1);

use App\Http\Requests\Statuses\UpdateStatusRequest;

it('fails when name is missing', function (): void {
    // Arrange
    $request = new UpdateStatusRequest();

    // Act
    $validator = validator()->make([
        // 'status' => 'active', // missing status
        'description' => 'Status is active',
    ], $request->rules());

    // Assert
    expect($validator->fails())->toBeTrue()
        ->and($validator->errors())->toHaveKey('name');
});

it('fails when name is not a string', function (): void {
    // Arrange
    $request = new UpdateStatusRequest();

    // Act
    $validator = validator()->make([
        'name' => 12345, // not a string
        'description' => 'Status is active',
    ], $request->rules());

    // Assert
    expect($validator->fails())->toBeTrue()
        ->and($validator->errors())->toHaveKey('name');
});

it('fails when name is too short', function (): void {
    // Arrange
    $request = new UpdateStatusRequest();

    // Act
    $validator = validator()->make([
        'name' => 'ac', // too short
        'description' => 'Status is active',
    ], $request->rules());

    // Assert
    expect($validator->fails())->toBeTrue()
        ->and($validator->errors())->toHaveKey('name');
});

it('fails when name is too long', function (): void {
    // Arrange
    $request = new UpdateStatusRequest();

    // Act
    $validator = validator()->make([
        'name' => str_repeat('a', 51), // too long
        'description' => 'Status is active',
    ], $request->rules());

    // Assert
    expect($validator->fails())->toBeTrue()
        ->and($validator->errors())->toHaveKey('name');
});

it('fails when description is not a string', function (): void {
    // Arrange
    $request = new UpdateStatusRequest();

    // Act
    $validator = validator()->make([
        'name' => 'active',
        'description' => 12345, // not a string
    ], $request->rules());

    // Assert
    expect($validator->fails())->toBeTrue()
        ->and($validator->errors())->toHaveKey('description');
});

it('fails when description is too short', function (): void {
    // Arrange
    $request = new UpdateStatusRequest();

    // Act
    $validator = validator()->make([
        'name' => 'active',
        'description' => 'a', // too short
    ], $request->rules());

    // Assert
    expect($validator->fails())->toBeTrue()
        ->and($validator->errors())->toHaveKey('description');
});

it('fails when description is too long', function (): void {
    // Arrange
    $request = new UpdateStatusRequest();

    // Act
    $validator = validator()->make([
        'name' => 'active',
        'description' => str_repeat('a', 256), // too long
    ], $request->rules());

    // Assert
    expect($validator->fails())->toBeTrue()
        ->and($validator->errors())->toHaveKey('description');
});
