<?php

declare(strict_types=1);

use App\Models\TeamTag;

it('has fillable attributes', function (): void {
    $teamTag = new TeamTag();

    expect($teamTag->getFillable())->toBe([
        'name',
        'description',
    ]);
});

test('to array', function (): void {

    $teamTag = TeamTag::factory()->create()->fresh();

    expect(array_keys($teamTag->toArray()))->toBe([
        'id',
        'name',
        'description',
        'created_at',
        'updated_at',
    ]);
});
