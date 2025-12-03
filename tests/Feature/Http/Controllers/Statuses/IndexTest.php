<?php 
declare(strict_types=1);

use App\Models\Status;

it('returns a list of statuses', function (): void {
    // Arrange
    Status::factory(2)->create();

    // Act
    $response = $this->getJson(route('api.v1.statuses.index'));

    // Assert
    expect($response->status())->toBe(200)
        ->and($response->json())->toHaveKeys(['message', 'status', 'data']);
});

it('returns 404 when no statuses exist', function (): void {
    // No statuses created here -> DB is empty

    // Act
    $response = $this->getJson(route('api.v1.statuses.index'));

    // Assert
    $response->assertStatus(404)
        ->assertJsonPath('message', 'statuses not found');
});