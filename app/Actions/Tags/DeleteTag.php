<?php

declare(strict_types=1);

namespace App\Actions\Tags;

use App\Models\Tag;

final class DeleteTag
{
    public function handle(int $id): bool
    {
        $tag = Tag::query()->find($id);
        if (is_null($tag)) {
            return false;
        }

        return $tag->delete();
    }
}
