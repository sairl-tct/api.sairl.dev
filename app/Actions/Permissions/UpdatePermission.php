<?php

declare(strict_types=1);

namespace App\Actions\Permissions;

use App\Models\Permission;

final class UpdatePermission
{
    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    public function handle(int $id, array $data): array
    {
        $permission = Permission::query()->find($id);

        if (is_null($permission)) {
            return [
                'message' => 'Permission not found',
                'status' => 'error',
                'code' => 404,
            ];
        }

        $duplicate = Permission::query()
            ->where('name', $data['name'])
            ->whereNot('id', $id)
            ->exists();

        if ($duplicate) {
            return [
                'message' => 'The name has already been taken.',
                'status' => 'error',
                'code' => 422,
            ];
        }

        $permission->update($data);

        return [
            'message' => 'update permission successfully',
            'status' => 'success',
            'code' => 200,
        ];
    }
}
