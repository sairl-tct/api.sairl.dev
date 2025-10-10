<?php

declare(strict_types=1);

use App\Models\Category;

it('\'s index returns categories json', function (): void {
    Category::factory()->create(['name' => 'Tech', 'slug' => 'tech'])->fresh();
    Category::factory()->create(['name' => 'Food', 'slug' => 'food'])->fresh();

    $response = $this->getJson(route('api.v1.categories.index'));

    $response->assertStatus(200)
        ->assertJsonCount(2)
        ->assertJsonFragment(['name' => 'Tech'])
        ->assertJsonFragment(['name' => 'Food']);
});

test('show returns a single category', function (): void {
    $category = Category::factory()->create(['name' => 'Tech', 'slug' => 'tech']);

    $response = $this->getJson(route('api.v1.categories.show', ['slug' => $category->slug]));

    $response->assertStatus(200)
        ->assertJsonFragment(['name' => 'Tech', 'slug' => 'tech']);
});

test('store creates a new category', function (): void {
    $payload = [
        'slug' => 'business',
        'name' => 'Business',
    ];

    $response = $this->postJson(route('api.v1.categories.store'), $payload);

    $response->assertStatus(200)
        ->assertJsonFragment($payload);

    $this->assertDatabaseHas('categories', ['name' => 'Business']);
});
