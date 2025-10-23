<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Actions\Categories\CreateCategory;
use App\Actions\Categories\DeleteCategory;
use App\Actions\Categories\UpdateCategory;
use App\Actions\Queries\Categories\GetCategories;
use App\Actions\Queries\Categories\GetCategory;
use App\Helpers\ApiResponse;
use App\Http\Requests\Categories\StoreCategoryRequest;
use App\Http\Requests\Categories\UpdateCategoryRequest;
use Symfony\Component\HttpFoundation\JsonResponse;

final class CategoryController
{
    use ApiResponse;

    public function index(GetCategories $categories): JsonResponse
    {
        $response = $categories->handle();

        if ($response->isEmpty()) {
            return $this->notFound('categories not found');
        }

        return $this->success('categories retrieved successfully', $response);
    }

    public function show(string $slug, GetCategory $category): JsonResponse
    {
        $response = $category->handle($slug);

        if (is_null($response)) {
            return $this->notFound('category not found');
        }

        return $this->success('category retrieved successfully', $response);
    }

    public function store(StoreCategoryRequest $request, CreateCategory $createCategory): JsonResponse
    {
        $category = $request->validated();
        $response = $createCategory->handle($category);

        return $this->created('category created successfully', $response);
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
            return $this->notFound('category not found');
        }

        return $this->success('category deleted successfully');
    }
}
