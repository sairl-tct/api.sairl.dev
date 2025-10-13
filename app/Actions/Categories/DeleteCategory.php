<?php

declare(strict_types=1);

namespace App\Actions\Categories;

use App\Models\Category;

final class DeleteCategory
{
    public function handle(string $slug): bool
    {
        $category = Category::query()->where('slug', $slug)->first();
        if (is_null($category)) {
            return false;
        }

        return (bool) $category->delete();
    }
}
