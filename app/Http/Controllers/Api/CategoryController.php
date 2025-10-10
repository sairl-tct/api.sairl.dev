<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Actions\Categories\CreateCategory;
use App\Actions\Queries\Categories\GetCategories;
use App\Actions\Queries\Categories\GetCategory;
use App\Http\Requests\Categories\StoreCategoryRequest;
use Symfony\Component\HttpFoundation\JsonResponse;

final class CategoryController
{
    public function index(GetCategories $categories): JsonResponse
    {
        $response = $categories->handle();

        return response()->json($response, 200);
    }

    public function show(string $slug, GetCategory $category): JsonResponse
    {
        $response = $category->handle($slug);

        return response()->json($response, 200);
    }

    public function store(StoreCategoryRequest $request, CreateCategory $createCategory): JsonResponse
    {
        $category = $request->validated();
        $response = $createCategory->handle($category);

        return response()->json($response, 200);
    }
}
