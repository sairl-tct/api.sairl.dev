<?php 
declare(strict_types=1);

use App\Actions\Queries\Statuses\GetStatuses;
use App\Models\Status;
use Illuminate\Database\Eloquent\Collection;

it('status retrieved successfully', function (): void {
    // Arrange: 3 statuses in DB
    Status::factory()->count(3)->create();

    // action: get action statuses
    $action = app(GetStatuses::class);
    $result = $action->handle();

    expect($result)
        ->toBeInstanceOf(Collection::class)
        ->and(count($result))->toBe(3);

    // optionally check type of first item
    expect($result->first())->toBeInstanceOf(Status::class);
});