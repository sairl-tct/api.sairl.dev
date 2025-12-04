<?php

declare(strict_types=1);

use App\Models\Tag;
use App\Models\TeamTag;

it('returns a single team tag', function (TeamTag $teamTag): void {

    $response = $this->getJson(route('api.v1.team-tags.show', ['id' => $teamTag->id]));

    expect($response->getStatusCode())->toBeInt('200')
        ->and($response->json('data'))->toMatchArray([
            'id' => $teamTag->id,
            'name' => $teamTag->name,
        ]);
})->with([
    fn () => TeamTag::factory()->create(['name' => 'active']),
]);

it('returns 404 when team tag is not found', function (): void {
    $id = 9999; // assuming this ID does not exist

    $response = $this->getJson(route('api.v1.team-tags.show', ['id' => $id]));
    // dd($response->getStatusCode());
    // Assert
    $response->assertStatus(404)
        ->assertJsonPath('message', 'team tag not found');
});
