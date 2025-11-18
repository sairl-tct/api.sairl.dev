<?php

declare(strict_types=1);

use App\Actions\Categories\DeleteCategory;
use App\Models\Category;

it('may delete a category', function (): void {
    // Arrange: create a category
    $category = Category::factory()->create([
        'name' => 'Laravel',
        'description' => 'PHP framework',
    ]);

    // Act: call action with the UUID primary key
    $action = app(DeleteCategory::class);
    $result = $action->handle($category->id);

    // Assert: action returns true and record is deleted
    expect($result)->toBeTrue()
        ->and(Category::query()->find($category->id))->toBeNull();
});

it('returns false when category does not exist', function (): void {
    // Arrange: some fake UUID that doesn't exist
    $fakeUuid = '00000000-0000-0000-0000-000000000000';

    // Act
    $action = app(DeleteCategory::class);
    $result = $action->handle($fakeUuid);

    // Assert
    expect($result)->toBeFalse();
});
