<?php

declare(strict_types=1);

use App\Actions\Categories\CreateCategory;
use App\Models\Category;

it('may create a category', function (): void {
    $action = app(CreateCategory::class);

    $categoryAction = $action->handle([
        'slug' => 'value',
        'name' => 'value',
        'description' => 'value_desc',
    ]);

    expect($categoryAction)->toBeInstanceOf(Category::class)
        ->and($categoryAction->slug)->toBe('value')
        ->and(Category::query()->count())->toBe(1);
});
