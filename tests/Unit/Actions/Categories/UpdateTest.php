<?php

declare(strict_types=1);

use App\Actions\Categories\UpdateCategory;
use App\Models\Category;

it('updates a category successfully', function (): void {
    $category = Category::factory()->create([
        'slug' => 'laravel',
        'name' => 'Laravel',
        'description' => 'Old description',
    ]);

    $data = [
        'name' => 'Laravel 12',
        'description' => 'Modern PHP framework',
    ];

    // action
    $action = app(UpdateCategory::class);
    $result = $action->handle($category->slug, $data);

    // Assert response structure
    expect($result)
        ->toBeArray()
        ->and($result['status'])->toBe('success')
        ->and($result['message'])->toBe('category updated successfully')
        ->and($result['code'])->toBe(200);

    // Assert DB actually updated
    $this->assertDatabaseHas('categories', [
        'id' => $category->id,
        'name' => 'Laravel 12',
        'description' => 'Modern PHP framework',
    ]);
});

it('return error when category is not found', function (): void {
    // Arrange: do NOT create any category with this slug
    $slug = 'unknown-slug';

    $data = [
        'name' => 'Whatever',
        'description' => 'Whatever',
    ];

    // action: call action UpdateCategory
    $action = app(UpdateCategory::class);
    $result = $action->handle($slug, $data);

    // Assert
    expect($result)
        ->toBeArray()
        ->and($result['status'])->toBe('error')
        ->and($result['message'])->toBe('Category not found.')
        ->and($result['code'])->toBe(404);
});

it('return error when the name is duplicate', function (): void {
    // Category A with name "Laravel"
    Category::factory()->create([
        'slug' => 'laravel',
        'name' => 'Laravel',
    ]);

    // Category B we'll try to update
    $categoryToUpdate = Category::factory()->create([
        'slug' => 'php',
        'name' => 'PHP',
    ]);

    $data = [
        'name' => 'Laravel',
    ];

    $action = app(UpdateCategory::class);
    $result = $action->handle($categoryToUpdate->slug, $data);

    expect($result)
        ->toBeArray()
        ->and($result['status'])->toBe('error')
        ->and($result['message'])->toBe('The name has already been taken.')
        ->and($result['code'])->toBe(422);
});
