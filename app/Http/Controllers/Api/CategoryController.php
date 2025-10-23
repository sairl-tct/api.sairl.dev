<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Actions\Categories\CreateCategory;
use App\Actions\Categories\DeleteCategory;
use App\Actions\Categories\UpdateCategory;
use App\Actions\Queries\Categories\GetCategories;
use App\Actions\Queries\Categories\GetCategory;
use App\Http\Requests\Categories\StoreCategoryRequest;
use App\Http\Requests\Categories\UpdateCategoryRequest;
use Symfony\Component\HttpFoundation\JsonResponse;

final class CategoryController
{
    public function index(GetCategories $categories): JsonResponse
    {
        $response = $categories->handle();

        if ($response->isEmpty()) {
            return response()->json([
                'message' => 'categories is empty',
                'status' => 'error',
            ], 422);
        }

        return response()->json(
            [
                'data' => $response,
                'message' => 'retrieved categories successfully',
                'status' => 'success',
            ]);
    }

    public function show(string $slug, GetCategory $category): JsonResponse
    {
        $response = $category->handle($slug);

        if (is_null($response)) {
            return response()->json([
                'message' => 'category is not exist',
                'status' => 'error',
            ], 422);
        }

        return response()->json([
            'data' => $response,
            'message' => 'retrieved category successfully',
            'status' => 'success',
        ]);
    }

    public function store(StoreCategoryRequest $request, CreateCategory $createCategory): JsonResponse
    {
        $category = $request->validated();
        $response = $createCategory->handle($category);

        return response()->json([
            'data' => $response,
            'message' => 'create category successfully',
            'status' => 'success',
        ], 201);
    }

    public function update(string $slug, UpdateCategoryRequest $request, UpdateCategory $updateCategory): JsonResponse
    {

        $category = $request->validated();
        /** @var array{status: string, message: string, code: int, data?: mixed} $response */
        $response = $updateCategory->handle($slug, $category);

        return response()->json([
            'message' => $response['message'],
            'status' => $response['status'],
        ], $response['code']);
    }

    public function destroy(string $slug, DeleteCategory $deleteCategory): JsonResponse
    {
        $response = $deleteCategory->handle($slug);

        if (! $response) {
            return response()->json([
                'message' => 'cannot delete category',
                'status' => 'error',
            ], 422);
        }

        return response()->json([
            'message' => 'delete category successfully',
            'status' => 'success',
        ]);
    }
}
