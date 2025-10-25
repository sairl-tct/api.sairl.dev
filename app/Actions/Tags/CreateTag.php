<?php

declare(strict_types=1);

namespace App\Actions\Tags;

use App\Models\Tag;

final class CreateTag
{
    /**
     * @param  array<string, mixed>  $data
     */
    public function handle(array $data): Tag
    {
        return Tag::query()->create($data);
    }
}
