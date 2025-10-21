<?php

declare(strict_types=1);

namespace App\Actions\Queries\Statuses;

use App\Models\Status;
use Illuminate\Database\Eloquent\Collection;

final class GetStatuses
{
    /**
     * @return Collection<int, Status>
     */
    public function handle(): Collection
    {
        return Status::all();
    }
}
