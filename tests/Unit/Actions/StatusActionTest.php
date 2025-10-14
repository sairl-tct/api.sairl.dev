<?php

declare(strict_types=1);

it('may create a status', function (): void {
    // Arrange
    $payload = [
        'name' => 'test',
        'description' => 'test',
    ];

    // Act...
    $action = app(App\Actions\Statuses\CreateStatus::class);
    $status = $action->handle($payload);

    // Assert
    expect($status)
        ->toBeInstanceOf(App\Models\Status::class)
        ->and($status->name)->toBe('test')
        ->and($status->description)->toBe('test')
        ->and(App\Models\Status::query()->count())->toBe(1);
});
