<?php

declare(strict_types=1);

it('create a new category', function (): void {
    $payload = [
        'slug' => 'business',
        'name' => 'Business',
    ];

    $response = $this->postJson(route('api.v1.categories.store'), $payload);

    $response->assertStatus(201);

    $this->assertDatabaseHas('categories', ['name' => 'Business']);
});
