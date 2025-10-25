<?php

declare(strict_types=1);

namespace App\Actions\Queries\Tags;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Collection;

/**
 * @return Collection<int, Tag>
 */
final class GetTags
{
    public function handle(): Collection
    {
        return Tag::all();
    }
}
