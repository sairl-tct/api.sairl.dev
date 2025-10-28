<?php

declare(strict_types=1);

namespace App\Actions\TeamCategories;

use App\Models\TeamCategory;

final class DeleteTeamCategory
{
    public function handle(int $id): bool
    {
        $TeamCategory = TeamCategory::query()->find($id);
        if (is_null($TeamCategory)) {
            return false;
        }

        return (bool) $TeamCategory->delete();
    }
}
