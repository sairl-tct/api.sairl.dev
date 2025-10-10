<?php

declare(strict_types=1);

namespace App\Actions\Queries\Categories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

final class GetCategories
{
    /**
     * @return Collection<int, Category>
     */
    public function handle(): Collection
    {
        return Category::all();
    }
}
