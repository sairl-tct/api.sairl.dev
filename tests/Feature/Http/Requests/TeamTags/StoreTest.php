<?php

declare(strict_types=1);

use App\Http\Requests\TeamTags\StoreTeamTagRequest;
use App\Models\TeamTag;

it('fails when name is missing', function (): void {
    // Arrange
    $request = new StoreTeamTagRequest();

    // Act
    $validator = validator()->make([
        // 'name' => 'In Progress', // missing name
        'description' => 'Team tag indicating work is ongoing',
    ], $request->rules());

    // Assert
    expect($validator->fails())->toBeTrue()
        ->and($validator->errors())->toHaveKey('name');
});

it('fails when name is too short', function (): void {
    // Arrange
    $request = new StoreTeamTagRequest();

    // Act
    $validator = validator()->make([
        'name' => 'IP', // too short
        'description' => 'Team tag indicating work is ongoing',
    ], $request->rules());

    // Assert
    expect($validator->fails())->toBeTrue()
        ->and($validator->errors())->toHaveKey('name');
});

it('fails when name is not a string', function (): void {
    // Arrange
    $request = new StoreTeamTagRequest();

    // Act
    $validator = validator()->make([
        'name' => 12345, // not a string
        'description' => 'Team tag indicating work is ongoing',
    ], $request->rules());

    // Assert
    expect($validator->fails())->toBeTrue()
        ->and($validator->errors())->toHaveKey('name');
});

it('fails when name is too long', function (): void {
    // Arrange
    $request = new StoreTeamTagRequest();

    // Act
    $validator = validator()->make([
        'name' => str_repeat('a', 51), // too long
        'description' => 'Team tag indicating work is ongoing',
    ], $request->rules());

    // Assert
    expect($validator->fails())->toBeTrue()
        ->and($validator->errors())->toHaveKey('name');
});

it('fails when name is not unique', function (): void {
    // Arrange
    $existingStatusName = 'Completed';

    // Simulate existing status in the database
    TeamTag::factory()->create(['name' => $existingStatusName]);

    $request = new StoreTeamTagRequest();

    // Act
    $validator = validator()->make([
        'name' => $existingStatusName, // not unique
        'description' => 'Team tag indicating work is done',
    ], $request->rules());

    // Assert
    expect($validator->fails())->toBeTrue()
        ->and($validator->errors())->toHaveKey('name');
});

it('fails when description is too short', function (): void {
    // Arrange
    $request = new StoreTeamTagRequest();

    // Act
    $validator = validator()->make([
        'name' => 'In Progress',
        'description' => str_repeat('a', 256), // too long
    ], $request->rules());

    // Assert
    expect($validator->fails())->toBeTrue()
        ->and($validator->errors())->toHaveKey('description');
});

it('fails when description is too long', function (): void {
    // Arrange
    $request = new StoreTeamTagRequest();

    // Act
    $validator = validator()->make([
        'name' => 'In Progress',
        'description' => str_repeat('a', 256), // too long
    ], $request->rules());

    // Assert
    expect($validator->fails())->toBeTrue()
        ->and($validator->errors())->toHaveKey('description');
});

it('fails when description is not a string', function (): void {
    // Arrange
    $request = new StoreTeamTagRequest();
    // Act
    $validator = validator()->make([
        'name' => 'In Progress',
        'description' => 12345, // not a string
    ], $request->rules());

    // Assert
    expect($validator->fails())->toBeTrue()
        ->and($validator->errors())->toHaveKey('description');
});
