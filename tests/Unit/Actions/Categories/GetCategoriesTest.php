<?php

declare(strict_types=1);

use App\Actions\Queries\Categories\GetCategories;
use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

it('returns a list of categories', function () {
    // Arrange: 3 categories in DB
    Category::factory()->count(3)->create();

    // action: get action categories
    $categories= app(GetCategories::class);
    $result = $categories->handle();

    // Assert: structure & count
    expect($result)
        ->toBeInstanceOf(Collection::class)
        ->and(count($result))->toBe(3);

    // optionally check type of first item
    expect($result->first())->toBeInstanceOf(Category::class);
});

it('returns empty collection when there are no categories', function(){
    // Arrange: DB is empty (RefreshDatabase already handled this)

    // action: get action categories
    $categories = app(GetCategories::class);
    $result = $categories->handle();

    // Assert: empty collection
    expect($result)
        ->toBeInstanceOf(Collection::class)
        ->and($result)->toBeEmpty();
});