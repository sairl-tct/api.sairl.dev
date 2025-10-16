<?php

declare(strict_types=1);

namespace App\Actions\Roles;

use App\Models\Role;

final class DeleteRole {
    public function handle(int $id): bool
    {
        $role = Role::query()->where('id', $id)->first();
        if (is_null($role)) {
            return false;
        }

        return (bool) $role->delete();
    }
}
