<?php

declare(strict_types=1);

use App\Actions\Queries\Categories\GetCategory;
use App\Models\Category;

it('returns a single category', function (): void {
    // Arrange: create a category
    $category = Category::factory()->create([
        'name' => 'Laravel',
        'description' => 'Old description',
    ]);

    // Act: call action with UUID id
    $action = app(GetCategory::class);
    $result = $action->handle($category->id);

    // Assert
    expect($result)
        ->toBeInstanceOf(Category::class)
        ->and($result->id)->toBe($category->id)
        ->and($result->name)->toBe('Laravel')
        ->and($result->description)->toBe('Old description');
});

it('returns null when category is not found', function (): void {
    // Arrange: some fake UUID not in DB
    $fakeId = '00000000-0000-0000-0000-000000000000';

    // Act
    $action = app(GetCategory::class);
    $result = $action->handle($fakeId);

    // Assert
    expect($result)->toBeNull();
});
