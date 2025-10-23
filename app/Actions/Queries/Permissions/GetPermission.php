<?php

declare(strict_types=1);

namespace App\Actions\Queries\Permissions;

use App\Models\Permission;

final class GetPermission
{
    public function handle(int $id): ?Permission
    {
        return Permission::query()->find($id);
    }
}
