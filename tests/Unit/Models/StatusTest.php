<?php

declare(strict_types=1);

use App\Models\Status;

test('to array', function (): void {

    $status = Status::factory()->create()->fresh();

    expect(array_keys($status->toArray()))->toBe([
        'id',
        'name',
        'description',
        'created_at',
        'updated_at',
    ]);
});
