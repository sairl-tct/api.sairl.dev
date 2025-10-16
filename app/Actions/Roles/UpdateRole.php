<?php

declare(strict_types=1);

namespace App\Actions\Roles;

use App\Models\Role;

final class UpdateRole {
    /**
     * @params array<string, mixed> $data
     */
    public function handle(int $id, array $data): bool
    {
        $role = Role::query()->where('id', $id)->first();
        if (is_null($role)) {
            return false;
        }

        return $role->update($data);
    }
}
