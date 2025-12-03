<?php

declare(strict_types=1);

use App\Actions\Statuses\DeleteStatus;
use App\Models\Status;

it('deletes a status successfully', function (): void {
    // Arrange
    $status = Status::factory()->create([
        'name' => 'to be deleted',
        'description' => 'status to be deleted',
    ]);

    // Act...
    $action = app(DeleteStatus::class);
    $result = $action->handle($status->id);

    // Assert
    expect($result)->toBeTrue()
        ->and(Status::query()->find($status->id))->toBeNull();
});

it('returns false when status does not exist', function (): void {
    $fackeId = 9999; // Non-existent ID

    // Act...
    $action = app(DeleteStatus::class);
    $result = $action->handle($fackeId);

    // Assert
    expect($result)->toBeFalse();
});
