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

    public function index(GetCategories $categories): \Illuminate\Http\JsonResponse
    {
        $response = $categories->handle();

        if ($response->isEmpty()) {
            return $this->notFound('categories not found');
        }

        return $this->success('categories retrieved successfully', $response);
    }

    public function show(string $uuid, GetCategory $category): \Illuminate\Http\JsonResponse
    {
        $response = $category->handle($uuid);

        if (is_null($response)) {
            return $this->notFound('category not found');
        }

        return $this->success('category retrieved successfully', $response);
    }

    public function store(StoreCategoryRequest $request, CreateCategory $createCategory): \Illuminate\Http\JsonResponse
    {
        $category = $request->validated();
        $response = $createCategory->handle($category);

        return $this->created('category created successfully', $response);
    }

    public function update(string $uuid, UpdateCategoryRequest $request, UpdateCategory $updateCategory): JsonResponse
    {

        $category = $request->validated();
        /** @var array{status: string, message: string, code: int, data?: mixed} $response */
        $response = $updateCategory->handle($uuid, $category);

        return response()->json([
            'message' => $response['message'],
            'status' => $response['status'],
        ], $response['code']);
    }

    public function destroy(string $uuid, DeleteCategory $deleteCategory): \Illuminate\Http\JsonResponse
    {
        $response = $deleteCategory->handle($uuid);

        if (! $response) {
            return $this->notFound('category not found');
        }

        return $this->success('category deleted successfully');
    }
}
