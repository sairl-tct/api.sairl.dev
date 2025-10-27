<?php

declare(strict_types=1);

namespace App\Actions\Queries\TeamTags;

use App\Models\TeamTag;
use Illuminate\Database\Eloquent\Collection;

final class GetTeamTags
{
    /**
     * @return Collection<int, TeamTag>
     */
    public function handle(): Collection
    {
        return TeamTag::all();
    }
}
