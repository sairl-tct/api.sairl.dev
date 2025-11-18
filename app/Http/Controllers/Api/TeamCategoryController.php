<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Actions\Queries\TeamCategories\GetTeamCategories;
use App\Actions\Queries\TeamCategories\GetTeamCategory;
use App\Actions\TeamCategories\CreateTeamCategory;
use App\Actions\TeamCategories\DeleteTeamCategory;
use App\Actions\TeamCategories\UpdateTeamCategory;
use App\Helpers\ApiResponse;
use App\Http\Requests\TeamCategories\StoreTeamCategoryRequest;
use App\Http\Requests\TeamCategories\UpdateTeamCategoryRequest;
use Illuminate\Http\JsonResponse;

final class TeamCategoryController
{
    use ApiResponse;

    public function index(GetTeamCategories $getTeamCategories): JsonResponse
    {
        $response = $getTeamCategories->handle();
        if ($response->isEmpty()) {
            return $this->notFound('Team categories not found');
        }

        return $this->success('Team categories retrieved successfully', $response);
    }

    public function show(GetTeamCategory $getTeamCategory, int $id): JsonResponse
    {
        $response = $getTeamCategory->handle($id);
        if (is_null($response)) {
            return $this->notFound('Team category not found');
        }

        return $this->success('Team category retrieved successfully', $response);
    }

    public function store(StoreTeamCategoryRequest $request, CreateTeamCategory $createTeamCategory): JsonResponse
    {
        $TeamCategory = $request->validated();
        $response = $createTeamCategory->handle($TeamCategory);

        return $this->created('Team category created successfully', $response);
    }

    public function update(UpdateTeamCategoryRequest $request, UpdateTeamCategory $updateTeamCategory, int $id): JsonResponse
    {
        $TeamCategory = $request->validated();
        /** @var array{status: string, message: string, code: int, data: ?mixed} $response */
        $response = $updateTeamCategory->handle($id, $TeamCategory);

        return response()->json([
            'status' => $response['status'],
            'message' => $response['message'],
        ], $response['code']);
    }

    public function destroy(DeleteTeamCategory $deleteTeamCategory, int $id): JsonResponse
    {
        $response = $deleteTeamCategory->handle($id);
        if (! $response) {
            return $this->notFound('Team category not found');
        }

        return $this->success('Team category deleted successfully');
    }
}
