<?php

declare(strict_types=1);

it('creates a team tag successfully', function (): void {
    $payload = [
        'name' => 'In Progress',
    ];

    $response = $this->postJson(route('api.v1.team-tags.store'), $payload);

    $response->assertStatus(201);

    $this->assertDatabaseHas('team_tags', ['name' => 'In Progress']);
});
