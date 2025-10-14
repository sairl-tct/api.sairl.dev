<?php

declare(strict_types=1);

namespace App\Actions\Queries\Categories;

use App\Models\Category;

final class GetCategory
{
    public function handle(string $slug): ?Category
    {
        return Category::query()->where('slug', $slug)->first();
    }
}
