<?php

declare(strict_types=1);

namespace App\Actions\Roles;

use App\Models\Role;

final class CreateRole
{
    /**
     * @params array<string, mixed> $data
     */
    public function handle(array $data): Role
    {
        return Role::query()->create($data);
    }
}
