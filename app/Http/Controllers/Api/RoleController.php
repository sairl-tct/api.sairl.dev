<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Actions\Queries\Roles\GetRole;
use App\Actions\Queries\Roles\GetRoles;
use App\Actions\Roles\CreateRole;
use App\Actions\Roles\DeleteRole;
use App\Actions\Roles\UpdateRole;
use App\Helpers\ApiResponse;
use App\Http\Requests\Roles\StoreRoleRequest;
use App\Http\Requests\Roles\UpdateRoleRequest;
use Illuminate\Http\JsonResponse;

final class RoleController
{
    use ApiResponse;
    public function index(GetRoles $getRoles): JsonResponse
    {
        $response = $getRoles->handle();
        if ($response->isEmpty()) {
            return $this->notFound('roles not found');
        }

        return $this->success('retrieved roles successfully', $response);
    }

    public function show(GetRole $getRole, int $id): JsonResponse
    {
        $response = $getRole->handle($id);

        if (is_null($response)) {
            return $this->notFound('role not found');
        }

        return $this->success('retrieved role successfully', $response);
    }

    public function store(StoreRoleRequest $request, CreateRole $createRole): JsonResponse
    {
        $role = $request->validated();
        $response = $createRole->handle($role);

        return $this->created('role created successfully',$response);
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
            return $this->notFound('role not found');
        }

        return $this->success('role deleted successfully');
    }
}
