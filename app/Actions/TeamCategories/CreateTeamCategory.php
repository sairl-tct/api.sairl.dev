<?php

declare(strict_types=1);

namespace App\Actions\TeamCategories;

use App\Models\TeamCategory;

final class CreateTeamCategory
{
    /**
     * @param  array<string, mixed>  $data
     */
    public function handle(array $data): TeamCategory
    {
        return TeamCategory::query()->create($data);
    }
}
