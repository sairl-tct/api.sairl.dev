<?php

declare(strict_types=1);

namespace App\Actions\Permissions;

use App\Models\Permission;

final class CreatePermission
{
    /**
     * @param  array<string, mixed>  $data
     */
    public function handle(array $data): Permission
    {
        return Permission::query()->create($data);
    }
}
