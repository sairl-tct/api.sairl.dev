<?php

declare(strict_types=1);
use App\Models\Category;

it('has fillable attributes', closure: function (): void {
    $category = Category::factory()->create();

    expect($category->getFillable())->toBe(['name', 'description']);
});

test('to array', function (): void {
    $category = Category::factory()->create()->fresh();
    expect(array_keys($category->toArray()))
        ->toBe([
            'id',
            'name',
            'description',
            'created_at',
            'updated_at',
        ]);
});
