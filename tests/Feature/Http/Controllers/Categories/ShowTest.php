<?php

declare(strict_types=1);

use App\Models\Category;

it('dose response a single category', function (Category $category): void {

    $response = $this->getJson(route('api.v1.categories.show', ['slug' => $category->slug]));

    expect($response->getStatusCode())->toBeInt('200')
        ->and($response->json('data'))->toMatchArray([
            'id' => $category->id,
            'slug' => $category->slug,
            'name' => $category->name,
        ]);

})->with([
    fn () => Category::factory()->create(['name' => 'Tech', 'slug' => 'tech']),
]);

it('not found in response a single category', function (): void {
    $slug = 'test_1';
    $response = $this->getJson(route('api.v1.categories.show', ['slug' => $slug]));
    expect($response->getStatusCode())->toBe(404);
});
