<?php

declare(strict_types=1);

use App\Models\Tag;

it('returns a single tag', function (Tag $tag): void {

    $response = $this->getJson(route('api.v1.tags.show', ['id' => $tag->id]));

    expect($response->getStatusCode())->toBeInt('200')
        ->and($response->json('data'))->toMatchArray([
            'id' => $tag->id,
            'name' => $tag->name,
        ]);
})->with([
    fn () => Tag::factory()->create(['name' => 'active']),
]);

it('returns 404 when tag is not found', function (): void {
    $id = 9999; // assuming this ID does not exist

    $response = $this->getJson(route('api.v1.tags.show', ['id' => $id]));
    // dd($response->getStatusCode());
    // Assert
    $response->assertStatus(404)
        ->assertJsonPath('message', 'tag not found');
});
