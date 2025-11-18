<?php

declare(strict_types=1);

namespace App\Actions\Queries\Categories;

use App\Models\Category;

final class GetCategory
{
    public function handle(string $uuid): ?Category
    {
        return Category::query()->find($uuid);
    }
}
