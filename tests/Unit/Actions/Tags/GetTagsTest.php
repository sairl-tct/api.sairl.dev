<?php

declare(strict_types=1);

use App\Actions\Queries\Tags\GetTags;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Collection;

it('tag retrieved successfully', function (): void {
    // Arrange: 3 tags in DB
    Tag::factory()->count(3)->create();

    // action: get action tags
    $action = app(GetTags::class);
    $result = $action->handle();

    expect($result)
        ->toBeInstanceOf(Collection::class)
        ->and(count($result))->toBe(3);

    // optionally check type of first item
    expect($result->first())->toBeInstanceOf(Tag::class);
});
