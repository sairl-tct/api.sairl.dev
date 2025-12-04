<?php

declare(strict_types=1);

use App\Models\Tag;

it('has fillable attributes', function (): void {
    $tag = new Tag();

    expect($tag->getFillable())->toBe([
        'name',
        'description',
    ]);
});

test('to array', function (): void {

    $tag = Tag::factory()->create()->fresh();

    expect(array_keys($tag->toArray()))->toBe([
        'id',
        'name',
        'description',
        'created_at',
        'updated_at',
    ]);
});
