<?php

declare(strict_types=1);

namespace App\Actions\Statuses;

use App\Models\Status;

final class CreateStatus
{
    /**
     * @param  array<string, mixed>  $data
     */
    public function handle(array $data): Status
    {
        return Status::query()->create($data);
    }
}
