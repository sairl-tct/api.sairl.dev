<?php

declare(strict_types=1);
use App\Actions\Tags\CreateTag;
use App\Models\Tag;

it('creates a tag successfully', function (): void {
    // Arrange
    $payload = [
        'name' => 'test',
        'description' => 'test',
    ];

    // Act...
    $action = app(CreateTag::class);
    $tag = $action->handle($payload);

    // Assert
    expect($tag)
        ->toBeInstanceOf(Tag::class)
        ->and($tag->name)->toBe('test')
        ->and($tag->description)->toBe('test')
        ->and(Tag::query()->count())->toBe(1);
});
