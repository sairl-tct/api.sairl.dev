<?php

declare(strict_types=1);

use App\Models\Category;

it('does return list of categories', function (): void {
    $response = $this->getJson(route('api.v1.categories.index'));

    expect($response->status())->toBe(200)
        ->and($response->json())->toHaveKeys(['message', 'status', 'data']);
})->with([
    fn () => Category::factory()->create(['name' => 'Tech', 'slug' => 'tech'])->fresh(),
    fn () => Category::factory()->create(['name' => 'Food', 'slug' => 'food'])->fresh(),
]);

it('does return empty list of category', function (): void {
    $response = $this->getJson(route('api.v1.categories.index'));

    expect($response->getStatusCode())->toBe(422);
})->with([
    fn () => Category::factory()->raw(),
]);

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

it('create a new category', function (): void {
    $payload = [
        'slug' => 'business',
        'name' => 'Business',
    ];

    $response = $this->postJson(route('api.v1.categories.store'), $payload);

    $response->assertStatus(201);

    $this->assertDatabaseHas('categories', ['name' => 'Business']);
});

it('delete a category', function (Category $category): void {

    $response = $this->deleteJson(route('api.v1.categories.destroy', ['slug' => $category->slug]));

    expect($response->getStatusCode())->toBe(200);

    $this->assertDatabaseCount('categories', 0);
})->with([
    fn () => Category::factory()->create(['name' => 'Tech', 'slug' => 'tech'])->fresh(),
]);

it('fail to delete a category', function (): void {
    $response = $this->deleteJson(route('api.v1.categories.destroy', ['slug' => 'test']));

    expect($response->getStatusCode())->toBe(422);

    $this->assertDatabaseCount('categories', 1);
})->with([
    fn () => Category::factory()->create(['name' => 'Tech', 'slug' => 'tech'])->fresh(),
]);
