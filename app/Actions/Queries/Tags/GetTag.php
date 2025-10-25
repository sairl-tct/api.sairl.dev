<?php

declare(strict_types=1);

namespace App\Actions\Queries\Tags;

use App\Models\Tag;

final class GetTag
{
    public function handle(int $id): ?Tag
    {
        return Tag::query()->find($id);
    }
}
