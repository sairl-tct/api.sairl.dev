<?php

declare(strict_types=1);

namespace App\Actions\Queries\Roles;

use App\Models\Role;
use Illuminate\Database\Eloquent\Collection;

final class GetRoles {
    /**
     * @return Collection<int, Role>
     */
    public function handle():Collection {
        return Role::all();
    }
}
