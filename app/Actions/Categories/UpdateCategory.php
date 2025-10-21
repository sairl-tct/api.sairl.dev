<?php

declare(strict_types=1);

namespace App\Actions\Categories;

use App\Models\Category;

final class UpdateCategory {
    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    public function handle(string $slug, array $data): array
    {
        $category = Category::query()->where('slug', $slug)->first();

        if (is_null($category)) {
            return [
                'status' => 'error',
                'message' => 'Role not found.',
                'code' => 404,
            ];
        }

        $duplicate = Category::query()
            ->where('name', $data['name'])
            ->where('slug', '!=', $slug)
            ->exists();

        if ($duplicate) {
            return [
                'status' => 'error',
                'message' => 'The name has already been taken.',
                'code' => 422,
            ];
        }

        $category->update($data);

        return [
            'status' => 'success',
            'message' => 'update role successfully',
            'code' => 200,
        ];
    }
}
