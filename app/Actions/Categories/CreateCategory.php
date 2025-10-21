<?php

declare(strict_types=1);

namespace App\Actions\Categories;

use App\Models\Category;

final class CreateCategory
{
    /**
     * @param  array<string, mixed>  $data
     */
    public function handle(array $data): Category
    {
        return Category::query()->create($data);
        
    }
}
