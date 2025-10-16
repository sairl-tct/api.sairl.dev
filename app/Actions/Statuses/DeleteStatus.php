<?php

declare(strict_types=1);

namespace App\Actions\Statuses;

use App\Models\Status;

final class DeleteStatus
{
    public function handle(int $id): bool
    {
        $status = Status::query()->where('id', $id)->first();
        if (is_null($status)) {
            return false;
        }

        return (bool) $status->delete();
    }
}
