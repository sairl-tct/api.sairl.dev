<?php

declare(strict_types=1);

namespace App\Actions\Queries\TeamTags;

use App\Models\TeamTag;

final class GetTeamTag {
    public function handle(int $id):? TeamTag
    {
        return TeamTag::query()->find($id);
    }
}
