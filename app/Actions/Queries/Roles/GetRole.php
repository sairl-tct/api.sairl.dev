<?php

declare(strict_types=1);

namespace App\Actions\Queries\Roles;

use App\Models\Role;

final class GetRole {
    public function handle(int $id): ?Role
    {
        return Role::query()->where('id', $id)->first();
    }
}
