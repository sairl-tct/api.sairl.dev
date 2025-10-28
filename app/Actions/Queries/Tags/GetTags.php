<?php

declare(strict_types=1);

namespace App\Actions\Queries\Tags;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Collection;

final class GetTags
{
    /**
     * @return Collection<int, Tag>
     */
    public function handle(): Collection
    {
        return Tag::all();
    }
}
