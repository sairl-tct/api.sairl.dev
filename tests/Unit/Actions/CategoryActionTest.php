<?php

declare(strict_types=1);

namespace Tests\Unit\Actions;

use App\Actions\Categories\CreateCategory;
use App\Actions\Categories\DeleteCategory;
use App\Models\Category;

it('creates a category', function (): void {
    $action = app(CreateCategory::class);

    $categoryAction = $action->handle([
        'slug' => 'laravel',
        'name' => 'Laravel',
        'description' => 'Laravel framework',
    ]);

    expect($categoryAction)
        ->toBeInstanceOf(Category::class)
        ->and($categoryAction->slug)->toBe('laravel')
        ->and(Category::query()->count())->toBe(1);
});

it('delete a category', function (): void {
    $action = app(DeleteCategory::class);

    $category = Category::factory()->create([
        'slug' => 'laravel',
        'name' => 'Laravel',
    ]);

    $result = $action->handle($category->slug);

    expect($result)->toBeTrue()
        ->and(Category::query()->find($category->id))->toBeNull();
});
