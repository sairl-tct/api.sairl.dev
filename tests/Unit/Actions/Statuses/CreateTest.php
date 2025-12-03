<?php

declare(strict_types=1);
use App\Actions\Statuses\CreateStatus;
use App\Models\Status;

it('creates a status successfully', function (): void {
    // Arrange
    $payload = [
        'name' => 'test',
        'description' => 'test',
    ];

    // Act...
    $action = app(CreateStatus::class);
    $status = $action->handle($payload);

    // Assert
    expect($status)
        ->toBeInstanceOf(Status::class)
        ->and($status->name)->toBe('test')
        ->and($status->description)->toBe('test')
        ->and(Status::query()->count())->toBe(1);
});

