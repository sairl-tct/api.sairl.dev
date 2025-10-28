<?php

declare(strict_types=1);

namespace App\Actions\Queries\TeamCategories;

use App\Models\TeamCategory;
use Illuminate\Database\Eloquent\Collection;


final class GetTeamCategories {
    /**
     *
     * @return Collection<int, TeamCategory>
     */
    public function handle(): Collection
    {
        return TeamCategory::all();
    }
}
