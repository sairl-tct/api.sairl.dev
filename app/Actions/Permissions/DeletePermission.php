<?php

declare(strict_types=1);

namespace App\Actions\Permissions;

use App\Models\Permission;

final class DeletePermission {
    public function handle(int $id): bool
    {
        $permission = Permission::query()->find($id);
        if (is_null($permission)) {
            return false;
        }
        return (bool) $permission->delete();
    }
}
