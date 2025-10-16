<?php

declare(strict_types=1);

use App\Actions\Categories\DeleteCategory;
use App\Models\Category;

it('may delete a category', function (): void {
    $action = app(DeleteCategory::class);

    $category = Category::factory()->create([
        'slug' => 'laravel',
        'name' => 'Laravel',
    ]);

    $result = $action->handle($category->slug);

    expect($result)->toBeTrue()
        ->and(Category::query()->find($category->id))->toBeNull();
});
