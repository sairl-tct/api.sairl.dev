<?php

declare(strict_types=1);

use App\Models\Category;

it('delete a category', function (Category $category): void {

    $response = $this->deleteJson(route('api.v1.categories.destroy', ['slug' => $category->slug]));

    expect($response->getStatusCode())->toBe(200);

    $this->assertDatabaseCount('categories', 0);
})->with([
    fn () => Category::factory()->create(['name' => 'Tech', 'slug' => 'tech'])->fresh(),
]);

it('fail to delete a category', function (): void {
    $response = $this->deleteJson(route('api.v1.categories.destroy', ['slug' => 'test']));

    expect($response->getStatusCode())->toBe(404);

    $this->assertDatabaseCount('categories', 1);
})->with([
    fn () => Category::factory()->create(['name' => 'Tech', 'slug' => 'tech'])->fresh(),
]);
