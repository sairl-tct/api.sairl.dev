<?php 
declare(strict_types=1);

use App\Actions\Statuses\UpdateStatus;
use App\Models\Status;

it('update a status successfully', function (): void {
    $status = Status::factory()->create([
        'name' => 'Open',
        'description' => 'The task is open',
    ]);

    $data = [
        'name' => 'Closed',
        'description' => 'The task is closed',
    ];

    $action = app(UpdateStatus::class);
    $result = $action->handle($status->id, $data);
    expect($result)
        ->toBeArray()
        ->and($result['status'])->toBe('success')
        ->and($result['message'])->toBe('update status successfully')
        ->and($result['code'])->toBe(200);
});

it('return error when status is not found', function (): void {
    $fakeId = 9999;

    $data = [
        'name' => 'Closed',
        'description' => 'The task is closed',
    ];

    $action = app(UpdateStatus::class);
    $result = $action->handle($fakeId, $data);

    expect($result)
        ->toBeArray()
        ->and($result['status'])->toBe('error')
        ->and($result['message'])->toBe('status not found')
        ->and($result['code'])->toBe(404);
});

it('return error when the name is duplicate', function ():void{
    $statusA = Status::factory()->create([
        'name' => 'Open',
        'description' => 'The task is open',
    ]);
    $statusB = Status::factory()->create([
        'name' => 'Closed',
        'description' => 'The task is closed',
    ]);

    $data = [
        'name' => 'Closed', // duplicate name
        'description' => 'Trying to duplicate name',
    ];
    $action = app(UpdateStatus::class);
    $result = $action->handle($statusA->id, $data);

    expect($result)
        ->toBeArray()
        ->and($result['status'])->toBe('error')
        ->and($result['message'])->toBe('The name has already been taken.')
        ->and($result['code'])->toBe(422);
});