<?php

declare(strict_types=1);

namespace App\Actions\Queries\TeamCategories;

use App\Models\TeamCategory;

final class GetTeamCategory
{
    public function handle(int $id): ?TeamCategory
    {
        return TeamCategory::query()->find($id);
    }
}
