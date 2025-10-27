<?php

declare(strict_types=1);

namespace App\Actions\TeamTags;

use App\Models\TeamTag;

final class CreateTeamTag {
    /**
     *
     * @param array<string, mixed> $data
     */
    public function handle(array $data): TeamTag
    {
        return TeamTag::query()->create($data);
    }
}
