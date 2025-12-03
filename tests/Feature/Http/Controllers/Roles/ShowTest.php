<?php

declare(strict_types=1);

use App\Models\Role;

it('returns a single role', function (Role $role): void {

    $response = $this->getJson(route('api.v1.roles.show', ['id' => $role->id]));
    expect($response->getStatusCode())->toBeInt('200')
        ->and($response->json('data'))->toMatchArray([
            'id' => $role->id,
            'name' => $role->name,
        ]);
})->with([
    fn () => Role::factory()->create(['name' => 'active']),
]);

it('returns 404 when role is not found', function (): void {
    $id = 9999; // assuming this ID does not exist

    $response = $this->getJson(route('api.v1.roles.show', ['id' => $id]));
    // dd($response->getStatusCode());
    // Assert
    $response->assertStatus(404)
        ->assertJsonPath('message', 'role not found');
});
