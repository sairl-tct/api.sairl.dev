<?php

declare(strict_types=1);

use App\Models\Category;

it('do response a single category', function (Category $category): void {

    $response = $this->getJson(route('api.v1.categories.show', ['uuid' => $category->id]));

    expect($response->getStatusCode())->toBeInt('200')
        ->and($response->json('data'))->toMatchArray([
            'id' => $category->id,
            'name' => $category->name,
        ]);

})->with([
    fn () => Category::factory()->create(['name' => 'Tech']),
]);

it('not found in response a single category', function (): void {
    $uuid = '00000000-0000-0000-0000-000000000000'; // only letters, no numbers/underscore

    $response = $this->getJson(route('api.v1.categories.show', ['uuid' => $uuid]));

    $response->assertStatus(404)
        ->assertJsonPath('message', 'category not found');
});
