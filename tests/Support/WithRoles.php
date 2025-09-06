<?php

namespace Tests\Support;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

trait WithRoles
{
    protected function assignRole($user, string $role): void
    {
        $r = Role::firstOrCreate(['name' => $role]);
        $user->assignRole($r);
    }

    protected function givePermission($user, string $permission): void
    {
        $p = Permission::firstOrCreate(['name' => $permission]);
        $user->givePermissionTo($p);
    }
}

