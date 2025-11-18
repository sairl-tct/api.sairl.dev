<?php

declare(strict_types=1);

namespace App\Actions\Categories;

use App\Models\Category;

final class UpdateCategory
{
    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    public function handle(string $uuid, array $data): array
    {
        $category = Category::query()->find($uuid);

        if (is_null($category)) {
            return [
                'status' => 'error',
                'message' => 'Category not found.',
                'code' => 404,
            ];
        }

        $duplicate = Category::query()
            ->where('name', $data['name'])
            ->whereNot('id', $uuid)
            ->exists();

        if ($duplicate) {
            return [
                'status' => 'error',
                'message' => 'The category has already been taken.',
                'code' => 422,
            ];
        }

        $category->update($data);

        return [
            'status' => 'success',
            'message' => 'category updated successfully',
            'code' => 200,
        ];
    }
}
