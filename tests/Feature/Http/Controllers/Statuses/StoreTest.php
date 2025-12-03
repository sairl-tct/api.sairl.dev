<?php

declare(strict_types=1);

it('creates a status successfully', function (): void {
    $payload = [
        'name' => 'In Progress',
    ];

    $response = $this->postJson(route('api.v1.statuses.store'), $payload);

    $response->assertStatus(201);

    $this->assertDatabaseHas('statuses', ['name' => 'In Progress']);
});
