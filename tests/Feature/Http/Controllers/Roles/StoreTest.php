<?php

declare(strict_types=1);

it('creates a role successfully', function (): void {
    $payload = [
        'name' => 'In Progress',
    ];

    $response = $this->postJson(route('api.v1.roles.store'), $payload);

    $response->assertStatus(201);

    $this->assertDatabaseHas('roles', ['name' => 'In Progress']);
});
