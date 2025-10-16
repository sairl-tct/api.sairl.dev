<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Actions\Queries\Roles\GetRole;
use App\Actions\Queries\Roles\GetRoles;
use App\Actions\Roles\CreateRole;
use App\Actions\Roles\UpdateRole;
use App\Http\Requests\Roles\StoreRoleRequest;
use Illuminate\Http\JsonResponse;

final class RoleController {
    public function index(GetRoles $getRoles):JsonResponse
    {
        $response = $getRoles->handle();
        if ($response->isEmpty()) {
            return response()->json([
                'message' => 'role is Empty',
                'status' => 'error'
            ],422);
        }
        return response()->json([
            'data' => $response,
            'message' => 'retrieve role successfully',
            'status' => 'success'
        ]);
    }

    public function show(GetRole $getRole, int $id): JsonResponse
    {
        $response = $getRole->handle($id);

        if (is_null($response)) {
            return response()->json([
                'message' => 'role is not exist',
                'status' => 'error'
            ],422);
        }

        return response()->json([
            'data' => $response,
            'message' => 'retrieve role successfully',
            'status' => 'success'
        ]);
    }

    public function store(StoreRoleRequest $request, CreateRole $createRole):JsonResponse
    {
        $role = $request->validated();
        $response = $createRole->handle($role);

        return response()->json([
            'data' => $response,
            'message' => 'create role successfully',
            'status' => 'success'
        ],201);
    }

    public function update(StoreRoleRequest $request, UpdateRole $updateRole, int $id): JsonResponse
    {

    }
}
