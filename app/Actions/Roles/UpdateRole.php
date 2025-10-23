<?php

declare(strict_types=1);

namespace App\Actions\Roles;

use App\Models\Role;

final class UpdateRole
{
    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    public function handle(int $id, array $data): array
    {
        $role = Role::query()->find($id);

        if (is_null($role)) {
            return [
                'status' => 'error',
                'message' => 'Role not found.',
                'code' => 404,
            ];
        }

        $duplicate = Role::query()
            ->where('name', $data['name'])
            ->where('id', '!=', $id)
            ->exists();

        if ($duplicate) {
            return [
                'status' => 'error',
                'message' => 'The name has already been taken.',
                'code' => 422,
            ];
        }

        $role->update($data);

        return [
            'status' => 'success',
            'message' => 'update role successfully',
            'code' => 200,
        ];
    }
}
