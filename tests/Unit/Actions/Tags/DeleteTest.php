<?php

declare(strict_types=1);

use App\Actions\Tags\DeleteTag;
use App\Models\Tag;

it('deletes a tag successfully', function (): void {
    // Arrange
    $tag = Tag::factory()->create([
        'name' => 'to be deleted',
        'description' => 'tag to be deleted',
    ]);

    // Act...
    $action = app(DeleteTag::class);
    $result = $action->handle($tag->id);

    // Assert
    expect($result)->toBeTrue()
        ->and(Tag::query()->find($tag->id))->toBeNull();
});

it('returns false when tag does not exist', function (): void {
    $fackeId = 9999; // Non-existent ID

    // Act...
    $action = app(DeleteTag::class);
    $result = $action->handle($fackeId);

    // Assert
    expect($result)->toBeFalse();
});
