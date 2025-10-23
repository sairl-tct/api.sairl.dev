<?php

declare(strict_types=1);

namespace App\Actions\Statuses;

use App\Models\Status;

final class UpdateStatus
{
    /**
     * @param  array<string, mixed>  $data
     */
    public function handle(int $id, array $data): bool
    {
        $status = Status::query()->where('id', $id)->first();
        if (is_null($status)) {
            return false;
        }

        return $status->update($data);
    }
}
