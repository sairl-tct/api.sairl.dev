<?php

declare(strict_types=1);

use App\Actions\Categories\UpdateCategory;
use App\Models\Category;

it('updates a category successfully', function (): void {
    $category = Category::factory()->create([
        'name' => 'Laravel',
        'description' => 'Old description',
    ]);

    $data = [
        'name' => 'Laravel 12',
        'description' => 'Modern PHP framework',
    ];

    // action
    $action = app(UpdateCategory::class);
    $result = $action->handle($category->id, $data); // 👈 use id, not slug

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
    // fake UUID that does not exist
    $fakeId = '00000000-0000-0000-0000-000000000000';

    $data = [
        'name' => 'Whatever',
        'description' => 'Whatever',
    ];

    $action = app(UpdateCategory::class);
    $result = $action->handle($fakeId, $data);

    expect($result)
        ->toBeArray()
        ->and($result['status'])->toBe('error')
        ->and($result['message'])->toBe('Category not found.')
        ->and($result['code'])->toBe(404);
});

it('return error when the name is duplicate', function (): void {
    // Category A with name "Laravel"
    $categoryA = Category::factory()->create([
        'name' => 'Laravel',
        'description' => 'A description',
    ]);

    // Category B we'll try to update
    $categoryToUpdate = Category::factory()->create([
        'name' => 'PHP',
        'description' => 'Another description',
    ]);

    $data = [
        'name' => 'Laravel', // duplicate name
    ];

    $action = app(UpdateCategory::class);
    $result = $action->handle($categoryToUpdate->id, $data); // 👈 use id

    expect($result)
        ->toBeArray()
        ->and($result['status'])->toBe('error')
        ->and($result['message'])->toBe('The category has already been taken.')
        ->and($result['code'])->toBe(422);
});
