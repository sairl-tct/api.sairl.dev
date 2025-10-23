<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Actions\Permissions\CreatePermission;
use App\Actions\Permissions\DeletePermission;
use App\Actions\Permissions\UpdatePermission;
use App\Actions\Queries\Permissions\GetPermission;
use App\Actions\Queries\Permissions\GetPermissions;
use App\Http\Requests\Permissions\StorePermissionRequest;
use App\Http\Requests\Permissions\UpdatePermissionRequest;
use Illuminate\Http\JsonResponse;

final class PermissionController
{
    use ApiResponse;
    public function index(GetPermissions $getPermissions): JsonResponse
    {
        $response = $getPermissions->handle();

        if($response->isEmpty())
        {
            return $this->notFound('permissions not found');
        }
        return $this->success('permission retrieved successfully', $response);
    }

    public function show(int $id, GetPermission $getPermission): JsonResponse
    {
        $response = $getPermission->handle($id);
        if(is_null($response))
        {
            return $this->notFound('permission not found');
        }

        return $this->success('permission retrieved successfully', $response);
    }

    public function store(StorePermissionRequest $request, CreatePermission $createPermission): JsonResponse
    {
        $permission = $request->validated();
        $response = $createPermission->handle($permission);

        return $this->created('permission created successfully', $response);
    }

    public function update(int $id, UpdatePermissionRequest$request, UpdatePermission $updatePermission): JsonResponse
    {
        $permission = $request->validated();
        /** @var array{status: string, message: string, code: int, data?: mixed} $response */
        $response = $updatePermission->handle($id, $permission);
        return response()->json([
            'status' => $response['status'],
            'message' => $response['message']
        ], $response['code']);
    }

    public function destroy(int $id, DeletePermission $deletePermission): JsonResponse
    {
        $response = $deletePermission->handle($id);

        if(!$response)
        {
            return $this->notFound('permission not found');
        }

        return $this->success('permission deleted successfully');
    }
}
