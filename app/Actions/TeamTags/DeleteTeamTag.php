<?php

declare(strict_types=1);

namespace App\Actions\TeamTags;

use App\Models\TeamTag;

final class DeleteTeamTag
{
    public function handle(int $id): bool
    {
        $TeamTag = TeamTag::query()->find($id);
        if (is_null($TeamTag)) {
            return false;
        }

        return (bool) $TeamTag->delete();
    }
}
