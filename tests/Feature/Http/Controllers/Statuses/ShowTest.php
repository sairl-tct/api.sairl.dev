<?php

declare(strict_types=1);

use App\Models\Status;

it('returns a single status', function (Status $status): void {

    $response = $this->getJson(route('api.v1.statuses.show', ['id' => $status->id]));

    expect($response->getStatusCode())->toBeInt('200')
        ->and($response->json('data'))->toMatchArray([
            'id' => $status->id,
            'name' => $status->name,
        ]);
})->with([
    fn () => Status::factory()->create(['name' => 'active']),
]);

it('returns 404 when status is not found', function (): void {
    $id = 9999; // assuming this ID does not exist

    $response = $this->getJson(route('api.v1.statuses.show', ['id' => $id]));
    // dd($response->getStatusCode());
    // Assert
    $response->assertStatus(404)
        ->assertJsonPath('message', 'status not found');
});
