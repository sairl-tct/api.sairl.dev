<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Actions\Queries\Roles\GetRole;
use App\Actions\Queries\Roles\GetRoles;
use App\Actions\Roles\CreateRole;
use App\Actions\Roles\DeleteRole;
use App\Actions\Roles\UpdateRole;
use App\Http\Requests\Roles\StoreRoleRequest;
use App\Http\Requests\Roles\UpdateRoleRequest;
use Illuminate\Http\JsonResponse;

final class RoleController
{
    public function index(GetRoles $getRoles): JsonResponse
    {
        $response = $getRoles->handle();
        if ($response->isEmpty()) {
            return response()->json([
                'message' => 'role is Empty',
                'status' => 'error',
            ], 422);
        }

        return response()->json([
            'data' => $response,
            'message' => 'retrieve role successfully',
            'status' => 'success',
        ]);
    }

    public function show(GetRole $getRole, int $id): JsonResponse
    {
        $response = $getRole->handle($id);

        if (is_null($response)) {
            return response()->json([
                'message' => 'role is not exist',
                'status' => 'error',
            ], 404);
        }

        return response()->json([
            'data' => $response,
            'message' => 'retrieve role successfully',
            'status' => 'success',
        ]);
    }

    public function store(StoreRoleRequest $request, CreateRole $createRole): JsonResponse
    {
        $role = $request->validated();
        $response = $createRole->handle($role);

        return response()->json([
            'data' => $response,
            'message' => 'create role successfully',
            'status' => 'success',
        ], 201);
    }

    public function update(UpdateRole $updateRole, UpdateRoleRequest $request, int $id): JsonResponse
    {
        $role = $request->validated();
        /** @var array{status: string, message: string, code: int, data?: mixed} $response */
        $response = $updateRole->handle($id, $role);

        return response()->json([
            'status' => $response['status'],
            'message' => $response['message'],
        ], $response['code']);
    }

    public function destroy(DeleteRole $deleteRole, int $id): JsonResponse
    {
        $response = $deleteRole->handle($id);
        if (! $response) {
            return response()->json([
                'message' => 'role is not exist',
                'status' => 'error',
            ]);
        }

        return response()->json([
            'message' => 'delete role successfully',
            'status' => 'success',
        ]);
    }
}
