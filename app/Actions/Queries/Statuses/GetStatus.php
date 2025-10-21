<?php

declare(strict_types=1);

namespace App\Actions\Queries\Statuses;

use App\Models\Status;

final class GetStatus
{
    public function handle(int $id): ?Status
    {
        return Status::query()->where('id', $id)->first();
    }
}
