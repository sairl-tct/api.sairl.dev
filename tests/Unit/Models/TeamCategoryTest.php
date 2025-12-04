<?php

declare(strict_types=1);

use App\Models\TeamCategory;

it('has fillable attributes', function (): void {
    $teamCategory = new TeamCategory();

    expect($teamCategory->getFillable())->toBe([
        'name',
        'description',
    ]);
});

test('to array', function (): void {

    $teamCategory = TeamCategory::factory()->create()->fresh();

    expect(array_keys($teamCategory->toArray()))->toBe([
        'id',
        'name',
        'description',
        'created_at',
        'updated_at',
    ]);
});
