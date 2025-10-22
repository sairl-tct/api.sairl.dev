<?php

declare(strict_types=1);

namespace App\Actions\Queries\Permissions;

use App\Models\Permission;
use Illuminate\Database\Eloquent\Collection;

final class GetPermissions {
    /**
     * @return Collection<int, Permission>
     */
    public function handle(): Collection
    {
        return Permission::all();
    }
}
