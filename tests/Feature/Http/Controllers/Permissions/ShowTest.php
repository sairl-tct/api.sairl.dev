<?php

declare(strict_types=1);

use App\Models\Permission;

it('returns a single permission', function (Permission $permission): void {

    $response = $this->getJson(route('api.v1.permissions.show', ['id' => $permission->id]));

    expect($response->getStatusCode())->toBeInt('200')
        ->and($response->json('data'))->toMatchArray([
            'id' => $permission->id,
            'name' => $permission->name,
        ]);
})->with([
    fn() => Permission::factory()->create(['name' => 'edit articles']),
]);

it('returns 404 when permission is not found', function (): void {
    $id = 9999; // assuming this ID does not exist

    $response = $this->getJson(route('api.v1.permissions.show', ['id' => $id]));
    // dd($response->getStatusCode());
    // Assert
    $response->assertStatus(404)
        ->assertJsonPath('message', 'permission not found');
});
