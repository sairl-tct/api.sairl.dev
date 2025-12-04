<?php

declare(strict_types=1);

it('creates a tag successfully', function (): void {
    $payload = [
        'name' => 'In Progress',
    ];

    $response = $this->postJson(route('api.v1.tags.store'), $payload);

    $response->assertStatus(201);

    $this->assertDatabaseHas('tags', ['name' => 'In Progress']);
});