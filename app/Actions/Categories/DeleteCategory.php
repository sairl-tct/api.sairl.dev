<?php

declare(strict_types=1);

namespace App\Actions\Categories;

use App\Models\Category;

final class DeleteCategory
{
    public function handle(string $uuid): bool
    {
        $category = Category::query()->find($uuid);
        if (is_null($category)) {
            return false;
        }

        return (bool) $category->delete();
    }
}
