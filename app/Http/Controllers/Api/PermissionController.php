<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

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
    public function index(GetPermissions $getPermissions): JsonResponse
    {
        $response = $getPermissions->handle();

        if($response->isEmpty())
        {
            return response()->json([
                'message' => 'permissions is empty',
                'status' => 'error'
            ], 422);
        }
        return response()->json([
            'data' => $response,
            'message' => 'retrieved permissions successfully',
            'status' => 'success'
        ]);
    }

    public function show(int $id, GetPermission $getPermission): JsonResponse
    {
        $response = $getPermission->handle($id);
        if(is_null($response))
        {
            return response()->json([
                'message' => 'permission not found',
                'status' => 'error'
            ],404);
        }

        return response()->json([
            'data' => $response,
            'message' => 'retrieved permission successfully',
            'status' => 'success'
        ]);
    }

    public function store(StorePermissionRequest $request, CreatePermission $createPermission): JsonResponse
    {
        $permission = $request->validated();
        $response = $createPermission->handle($permission);

        return response()->json([
            'data' => $response,
            'message' => 'create permission successfully',
            'status' => 'success'
        ],201);
    }

    public function update(int $id, UpdatePermissionRequest$request, UpdatePermission $updatePermission): JsonResponse
    {
        $permission = $request->validated();
        /** @var array{status: string, message: string, code: int, data?: mixed} $response */
        $response = $updatePermission->handle($id, $permission);
        return response()->json([
            'message' => $response['message'],
            'status' => $response['status'],
        ], $response['code']);
    }

    public function destroy(int $id, DeletePermission $deletePermission): JsonResponse
    {
        $response = $deletePermission->handle($id);

        if(!$response)
        {
            return response()->json([
                'message' => 'permission not found',
                'status' => 'error'
            ],404);
        }

        return response()->json([
            'message' => 'delete permission successfully',
            'status' => 'success'
        ]);
    }
}
